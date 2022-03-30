<?php

namespace App\Http\Controllers;

use App\Booking;
use App\BookingClass;
use App\Educator;
use App\ErrorLog;
use App\Helpers\ClassHubHelper;
use App\Helpers\PDFViewHelper;
use App\Jobs\IntercomJob;
use App\Jobs\SendEmailJob;
use App\Lesson;
use App\LessonClass;
use App\Mail\BookingEducator;
use App\Mail\BookingParent;
use App\Mail\ClassBookUpExpired;
use App\Mail\PaymentReceiptEducator;
use App\Mail\CancelLessonEducatorToEducator;
use App\Mail\CancelLessonEducatorToParent;
use App\Mail\CancelLessonParentToEducator;
use App\Mail\CancelLessonParentToParent;
use App\Mail\ClassReminder;
use App\Mail\RefundRequestParentToEducator;
use App\Mail\RefundRequestParentToParent;
use App\Mail\TermClassReminder;
use App\Message;
use App\RefundRequest;
use App\Setting;
use App\Transaction;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Stripe\Stripe;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->student_name) {
            return response()->json([
                'status' => false,
                'messages' => ['Please enter Student name'],
            ]);
        }
        
        $paymentCompleted = false;
        
        $charges = null;
        
        try {
            
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            
            $lesson = Lesson::findOrFail($request->lesson_id);
            
            $classes = explode(',', $request->class_ids);
            
            $educator = User::findOrFail($lesson->user_id);
            
            if (!$this->isClassBookable($lesson, $classes)) {
                return response()->json([
                    'status' => false,
                    'messages' => [Lang::get('messages.booking.error')]
                ]);
            }
            
            DB::beginTransaction();
            
            list($classFee, $serviceFee) = $this->getBookingAmounts($lesson, $classes);
            
            // Process payment
            
            $response = StripeController::processPaymentIntent($request, $educator, $classFee, $serviceFee);
            
            // Send back to client for next action or failed
            if ($response['status'] === false) {
                return response()->json($response['data']);
            }
            
            if ($response['status'] === true) {
                
                $paymentCompleted = true;
                
                $intent = $response['intent'];
                
                $charges = $intent->charges->data;
                
                $booking = Booking::create([
                    'user_id' => Auth::user()->id,
                    'code' => ClassHubHelper::uniqueCode(),
                    'student_name' => $request->student_name ? $request->student_name : Auth::user()->name,
                    'lesson_id' => $lesson->id,
                    'amount' => $charges[0]['amount'],
                    'application_fee' => $charges[0]['application_fee_amount'] !== null ? $charges[0]['application_fee_amount'] : 0,
                    'provider_fee_percent' => $educator->educator->provider_fee ? $educator->educator->provider_fee
                        : Setting::get('provider_fee'),
                    'service_fee' => $serviceFee,
                    'customer_fee_percent' => $educator->educator->customer_fee ? $educator->educator->customer_fee
                        : Setting::get('customer_fee'),
                    'stripe_fee' => $response['stripe_fee'],
                    'status' => 'completed'
                ]);
                
                $this->addBookingClasses($booking, $lesson, $classes);
                
                $this->updateBookingCounter($lesson, $classes);
                
                $messageController = new MessageController();
                
                $messageRequest = new Request();
                $messageRequest->setMethod('POST');
                
                $messageRequest->request->replace([
                    '_token' => csrf_token(),
                    'recipient_id' => $lesson->user_id,
                    'type' => 'booking_video_call',
                    'text' => '-',
                    'read' => 1,
                    'video_call_response' => 1,
                    'booking_response' => 1,
                    'lesson_id' => $lesson->id,
                    'class_ids' => implode(',', $lesson->classes->pluck('id')->toArray())
                ]);
                
                $response = json_decode($messageController->store($messageRequest, true)->getContent());
                
                
                if ($request->message_id) {
                    $message = Message::find($request->message_id);
                    $message->update(['booking_response' => 1]);
                    
                    $messageRequest = new Request();
                    $messageRequest->setMethod('POST');
                    
                    $messageRequest->request->replace([
                        '_token' => csrf_token(),
                        'recipient_id' => $lesson->user_id,
                        'text' => '<strong>You\'re booking has been accepted</strong><p>A confirmation email has been
                                sent and you can see your new booking in your dashboard <a href="' . route('educator.dashboard') . '">here</a></p>',
                    ]);
                    
                    $response = json_decode($messageController->store($messageRequest, true)->getContent());
                    
                }
                
                foreach ($charges as $charge) {
                    $this->storeTransaction($booking, $charge);
                }
            }
            
            DB::commit();
            
            // Send parent Receipt
            $this->sendReceiptParent($booking->id);
            
            // Send tutor Receipt
            $this->sendReceiptEducator($booking->id);
            
            // Check whether class is booked up
            $this->isLessonBookedUp($lesson->id);
            
            // Intercom Data
            $data = [
                'user_id' => $educator->id,
                'email' => $educator->email,
                'name' => $educator->name,
                'custom_attributes' => [
                    'Bookings no' => $educator->educator ? $educator->educatorBookings()->count() : $educator->bookings()->count(),
                ]
            ];
            
            $intercomJob = new IntercomJob($educator, $data);
            
            $this->dispatch($intercomJob);
            
            return response()->json([
                'status' => true,
                'data' => [
                    'booking' => $booking,
                    'lesson' => $lesson,
                    'qty' => $lesson->type === 'single' || $lesson->type === 'subject' ? count($classes) : 1
                ],
                'messages' => [Lang::get('messages.icon.ok'),
                    Lang::get('messages.booking.success', ['code' => ClassHubHelper::getbookingCode($booking)])]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log if Payment completed and Booking not success
            if ($paymentCompleted) {
                
                foreach ($charges as $charge) {
                    $this->storeTransaction(null, $charge);
                    
                    ErrorLog::create([
                        'user_id' => Auth::user()->id,
                        'type' => 'booking',
                        'data' => json_encode($charge),
                        'details' => 'Lesson ID: ' . $request->lesson_ids . ', Classes : ' . $request->class_ids,
                        'status' => 'failed'
                    ]);
                }
            }
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => $e->getMessage()
            ]);
        }
    }
    
    public function getBookingAmounts($lesson, $classes)
    {
        $educator = Educator::findOrFail($lesson->user_id);
        
        $classFee = $lesson->type === 'single' || $lesson->type === 'subject' ?
            count($classes) * $lesson->price : $lesson->price;
        
        $serviceFee = ClassHubHelper::roundCents(($educator->customer_fee ? $educator->customer_fee / 100 :
                Setting::get('customer_fee') / 100) * $classFee);
        
        return [$classFee, $serviceFee];
    }
    
    public function isClassBookable($lesson, $classes)
    {
        $bookable = true;
        
        if ($lesson->type === 'single' || $lesson->type === 'subject') {
            foreach ($classes as $classId) {
                $class = LessonClass::findOrFail($classId);
                
                if (!$class->is_bookable || $lesson->status != 'live') {
                    $bookable = false;
                    break;
                }
            }
        } else {
            $bookable = $lesson->bookable && $lesson->status == 'live';
        }
        
        return $bookable;
    }
    
    public function addBookingClasses($booking, $lesson, $classes)
    {
        $bookingClasses = [];
        
        if ($lesson->type === 'single' || $lesson->type === 'subject') {
            foreach ($classes as $classId) {
                $class = LessonClass::findOrFail($classId);
                array_push($bookingClasses, [
                    'booking_id' => $booking->id,
                    'lesson_class_id' => $classId,
                    'status' => 'completed'
                ]);
            }
        } else {
            foreach ($lesson->classes as $class) {
                array_push($bookingClasses, [
                    'booking_id' => $booking->id,
                    'lesson_class_id' => $class->id,
                    'status' => 'completed'
                ]);
            }
        }
        
        BookingClass::insert($bookingClasses);
    }
    
    public function updateBookingCounter($lesson, $classes)
    {
        // If single type update each class booking counter
        if ($lesson->type === 'single' || $lesson->type === 'subject') {
            
            foreach ($classes as $classId) {
                $lessonClass = LessonClass::findOrFail($classId);
                $numBookings = $lessonClass->num_bookings + 1;
                
                $lessonClass->update([
                    'num_bookings' => $numBookings,
                    'bookable' => !$lesson->max_num_bookings ? 1 : ($numBookings < $lesson->max_num_bookings ? 1 : 0),
                ]);
            }
            
        } else {
            $numBookings = $lesson->num_bookings + 1;
            $lesson->update([
                'num_bookings' => $numBookings,
                'bookable' => !$lesson->max_num_bookings ? 1 : ($numBookings < $lesson->max_num_bookings ? 1 : 0),
            ]);
        }
    }
    
    public function isLessonBookedUp($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        
        try {
            if ($lesson->type === 'single' || $lesson->type === 'subject') {
                
                $allBookedUp = true;
                
                foreach ($lesson->classes as $class) {
                    if ($class->num_bookings < $lesson->max_num_bookings) {
                        $allBookedUp = false;
                    }
                }
                
                if ($allBookedUp) {
                    $lesson->update(['bookable' => 0]);
                    
                    if ($lesson->type != 'subject') {
                        $job = new SendEmailJob($lesson->user->email, new ClassBookUpExpired($lesson->user, $lesson));
                        dispatch($job);
                    }
                }
            } else {
                
                if ($lesson->num_bookings == $lesson->max_num_bookings) {
                    $lesson->update(['bookable' => 0]);
                    
                    if ($lesson->type != 'subject') {
                        $job = new SendEmailJob($lesson->user->email, new ClassBookUpExpired($lesson->user, $lesson));
                        dispatch($job);
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
    
    public function storeTransaction($booking, $transaction)
    {
        return Transaction::create([
            'booking_id' => $booking ? $booking->id : null,
            'txn_id' => $transaction->id,
            'amount' => $transaction->amount,
            'txn_details' => json_encode($transaction),
            'status' => $transaction['status'] ? $transaction['status'] : 'succeeded',
            'type' => $transaction['object']
        ]);
    }
    
    public function getPaymentSummary(Request $request)
    {
        if (!Auth::check()) {
            return '<div style="text-align:center;width:100%">' .
                Lang::get('messages.auth.required', ['text' => ' to book a class']) . '</div>';
        }
        
        try {
            $lesson = Lesson::findOrFail($request->lesson_id);
            
            $educator = Educator::findOrFail($lesson->user_id);
            
            $classes = $lesson->type === 'single' || $lesson->type === 'subject' ? $request->class_ids :
                $lesson->classes->pluck('id')->toArray();
            
            $cards = Auth::user()->cards;
            
            $price = $lesson->type === 'single' || $lesson->type === 'subject' ?
                count($request->class_ids) * $lesson->price : $lesson->price;
            
            $serviceChargeAmount = round(($educator->customer_fee ? $educator->customer_fee / 100 :
                    Setting::get('customer_fee') / 100) * $price);
            
            $totalAmount = $price + $serviceChargeAmount;
            
            $messageId = $request->message_id ? $request->message_id : null;
            
            return View::make('frontend.includes.payment-summary', compact('lesson', 'classes',
                'serviceChargeAmount', 'price', 'totalAmount', 'cards', 'messageId'))->render();
            
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function sendReceiptParent($bookingId)
    {
        try {
            $booking = Booking::findOrFail($bookingId);
            
            $job = new SendEmailJob(Auth::user()->email, new BookingParent($booking, Auth::user()->email));
            
            $this->dispatch($job);
            
            return response()->json([
                'status' => true,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => $e->getMessage()
            ]);
        }
    }
    
    public function sendReceiptEducator($bookingId)
    {
        try {
            
            $booking = Booking::findOrFail($bookingId);
            
            $user = User::findOrFail($booking->lesson->user_id);
            
            $job = new SendEmailJob($user->email, new BookingEducator($booking, $user->email));
            
            $this->dispatch($job);
            
            return response()->json([
                'status' => true,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => $e->getMessage()
            ]);
        }
    }
    
    public function requestRefund(Request $request)
    {
        $validate = ClassHubHelper::validateData($request->all(), RefundRequest::VALIDATION_RULES);
        
        // Return array of errors if not validated
        if (is_array($validate))
            return response()->json($validate);
        
        try {
            DB::beginTransaction();
            
            $booking = Booking::findOrFail($request->booking_id);
            $requestGroup = uniqid();
            $refundableClasses = [];
            $messageResponse = null;
            
            foreach ($request->classes as $classId) {
                $bookingClass = BookingClass::where('booking_id', $booking->id)
                    ->where('lesson_class_id', $classId)->first();
                
                // Not refundable
                if (!$bookingClass->is_refundable || !$bookingClass->class->is_refundable)
                    continue;
                
                array_push($refundableClasses, $classId);
            }
            
            if (count($refundableClasses)) {
                
                // Deduct service fee and stripe fee as cancel fee
                $totalRefundableAmount = $booking->amount;  //- ($booking->service_fee + $booking->stripe_fee);
                
                $refundRequests = RefundRequest::where('booking_id', $booking->id)
                    ->where('status', '!=', 'decline')->get();
                $totalRequestedAmount = $refundRequests->sum('amount');
                
                $payouts = BookingClass::where('booking_id', $booking->id)
                    ->where('payout_amount', '!=', 0)->get();
                $totalPayoutAmount = $payouts->sum('payout_amount');
                
                $totalRefundedAndPayoutAmount = $totalRequestedAmount + $totalPayoutAmount;
                
                $singleClassAmount = ClassHubHelper::roundCents($totalRefundableAmount / $booking->classes->count());
                
                $amountToRefund = 0;
                
                $requestAndPayoutCount = $refundRequests->count() + $payouts->count();
                
                foreach ($refundableClasses as $refundableClass) {
                    
                    // Make cents off adjustment on the last class
                    if ($booking->classes->count() - $requestAndPayoutCount == 1) {
                        $singleClassAmount = $totalRefundableAmount - $totalRefundedAndPayoutAmount;
                        $amountToRefund += $totalRefundableAmount - $totalRefundedAndPayoutAmount;
                    } else {
                        $amountToRefund += $singleClassAmount;
                    }
                    
                    $totalRefundedAndPayoutAmount += $singleClassAmount;
                    
                    RefundRequest::create([
                        'booking_id' => $booking->id,
                        'lesson_class_id' => $refundableClass,
                        'group' => $requestGroup,
                        'amount' => $singleClassAmount,
                        'request_reason' => $request->message,
                        'status' => 'pending',
                        'action_by' => 'parent'
                    ]);
                    
                    $requestAndPayoutCount++;
                }
                
                $educator = User::findOrFail($booking->lesson->user_id);
                
                $educatorEmailJob = new SendEmailJob($educator->email,
                    new RefundRequestParentToEducator(Auth::user(), $educator, $booking,
                        $refundableClasses, $amountToRefund, $educator->email));
                
                $this->dispatch($educatorEmailJob);
                
                $parentEmailJob = new SendEmailJob(Auth::user()->email,
                    new RefundRequestParentToParent(Auth::user(), $educator, $booking,
                        $refundableClasses, $amountToRefund, Auth::user()->email));
                
                $this->dispatch($parentEmailJob);
                
                $messageController = new MessageController();
                $messageRequest = new Request();
                $messageRequest->setMethod('POST');
                
                $messageRequest->request->replace([
                    '_token' => csrf_token(),
                    'type' => 'refund_request',
                    'lesson_id' => $booking->lesson->id,
                    'recipient_id' => $booking->lesson->user_id,
                    'text' => $request->message,
                    'booking_id' => $booking->id,
                    'class_ids' => implode(',', $refundableClasses),
                ]);
                
                $messageResponse = json_decode($messageController->store($messageRequest, false)->getContent());
            }
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'redirect_url' => $messageResponse ? route('parent.inbox.message', $messageResponse->chat_id)
                    : route('parent.inbox'),
                'messages' => [
                    Lang::get('messages.icon.ok'),
                    count($refundableClasses) ? Lang::get('messages.refund.request.success') : 'No refundable classes found'
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => $e->getTrace()
            ]);
        }
    }
    
    
    public function cancelBooking($lessonId, $bookingId)
    {
        try {
            
            $lesson = Lesson::findOrFail($lessonId);
            
            $booking = Booking::findOrFail($bookingId);
            
            DB::beginTransaction();
            
            if ($lesson->type == 'single' || $lesson->type === 'subject') {
                list($cancellableBookingClasses, $successMessages, $errorMessages)
                    = $this->getCancellableSingleClasses($booking);
            } else {
                list($cancellableBookingClasses, $successMessages, $errorMessages)
                    = $this->getCancellableGroupTermClasses($booking);
            }
            
            if (count($cancellableBookingClasses)) {
                
                $this->refundOnCancelBooking($booking, $cancellableBookingClasses);
                
                $educator = User::findOrFail($lesson->user_id);
                
                $cancelledClasses = Arr::pluck($cancellableBookingClasses, 'id');
                
                $this->updateCancelBookingData($booking, $cancelledClasses);
                
                $parentJob = new SendEmailJob(Auth::user()->email,
                    new CancelLessonParentToParent($educator, $lesson, $cancelledClasses, Auth::user()->email));
                
                $educatorJob = new SendEmailJob($educator->email,
                    new CancelLessonParentToEducator($educator, Auth::user(), $lesson, $cancelledClasses, $educator->email));
                
                $this->dispatch($parentJob);
                $this->dispatch($educatorJob);
            }
            
            DB::commit();
            
            if (!empty($successMessages)) {
                array_merge([Lang::get('messages.icon.ok')], $successMessages);
            }
            
            if (empty($successMessages) && empty($errorMessages)) {
                array_push($errorMessages, 'Class(es) are already cancelled');
            }
            
            return response()->json([
                'status' => true,
                'messages' => array_merge($successMessages, $errorMessages),
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => $e->getTrace()
            ]);
        }
    }
    
    public function cancelClasses($lessonId)
    {
        try {
            
            DB::beginTransaction();
            
            $lesson = Lesson::findOrFail($lessonId);
            $cancellableClasses = [];
            
            $lesson->update(['bookable' => 0, 'status' => 'cancelled']);
            
            foreach ($lesson->classes as $class) {
                
                if (!$class->is_past_class) {
                    $class->update(['bookable' => 0, 'status' => 'cancelled']);
                    array_push($cancellableClasses, $class->id);
                }
            }
            
            if (count($cancellableClasses)) {
                
                // Get Bookings and refund Users
                foreach ($lesson->bookings as $booking) {
                    
                    $refundableBookingClasses = $this->getRefundableBookingClasses($booking, $cancellableClasses);
                    
                    // Check if user has cancellable classes
                    if (count($refundableBookingClasses)) {
                        
                        $this->refundOnCancelClass($booking, $refundableBookingClasses);
                        
                        // Send system email to Parent
                        $parent = User::findOrFail($booking->user_id);
                        $job = new SendEmailJob($parent->email,
                            new  CancelLessonEducatorToParent($parent, $lesson, $refundableBookingClasses, $parent->email));
                        $this->dispatch($job);
                    }
                }
                
                $educator = User::findOrFail($lesson->user_id);
                
                $job = new SendEmailJob($educator->email,
                    new CancelLessonEducatorToEducator($educator, $lesson, $cancellableClasses, $educator->email));
                $this->dispatch($job);
            }
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'id' => $lessonId,
                'messages' => [Lang::get('messages.icon.ok'), Lang::get('messages.lesson.cancelled')]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => $e->getTrace()
            ]);
        }
    }
    
    public function getRefundableBookingClasses($booking, $cancellableClasses)
    {
        $refundableBookingClasses = [];
        
        foreach ($booking->classes as $bookingClass) {
            
            // if class is not cancellable
            if (!in_array($bookingClass->lesson_class_id, $cancellableClasses))
                continue;
            
            // Cancelled or pay out
            if ($bookingClass->status === 'cancelled' || $bookingClass->has_been_payout)
                continue;
            
            // Check if User has requested refund for this class
            $refundRequest = RefundRequest::where('booking_id', $booking->id)
                ->where('lesson_class_id', $bookingClass->lesson_class_id)->first();
            
            if ($refundRequest && ($refundRequest->has_been_payout || $refundRequest->in_progress)) {
                continue;
            }
            
            array_push($refundableBookingClasses, $bookingClass->lesson_class_id);
            $bookingClass->update(['status' => 'cancelled', 'action_by' => 'tutor']);
        }
        
        return $refundableBookingClasses;
    }
    
    public function refundOnCancelBooking($booking, $cancellableBookingClasses)
    {
        $requestGroup = uniqid();
        $partialRefundAmount = 0;
        
        // Get the Charge transaction of booking
        $chargeTxn = $booking->transactions->where('amount', $booking->amount)
            ->where('type', 'charge')->where('status', 'succeeded')->first();
        
        foreach ($cancellableBookingClasses as $index => $cancellableBookingClass) {
            // 14 days rule applied
            if ($cancellableBookingClass['14days_rule'] && $cancellableBookingClass['refund']) {
                $singleClassPrice = ClassHubHelper::roundCents($booking->amount / $booking->classes->count());
            } else if ($cancellableBookingClass['refund']) {
                $bookingAmount = $booking->amount - ($booking->service_fee + $booking->stripe_fee);
                $partialRefundAmount = $singleClassPrice = ClassHubHelper::roundCents($bookingAmount / $booking->classes->count());
            } else {
                $singleClassPrice = 0;
            }
            $cancellableBookingClasses[$index]['amount'] = $singleClassPrice;
        }
        
        $totalRefundableAmount = $booking->amount;
        
        $refundRequests = RefundRequest::where('booking_id', $booking->id)
            ->where('status', '!=', 'decline')->get();
        $totalRequestedAmount = $refundRequests->sum('amount');
        
        $payouts = BookingClass::where('booking_id', $booking->id)
            ->where('payout_amount', '!=', 0)->get();
        $totalPayoutAmount = $payouts->sum('payout_amount');
        
        $totalRefundedAndPayoutAmount = $totalRequestedAmount + $totalPayoutAmount;
        
        $amountToRefund = 0;
        
        $requestAndPayoutCount = $refundRequests->count() + $payouts->count();
        
        foreach ($cancellableBookingClasses as $cancellableBookingClass) {
            
            // Make cents off adjustment on the last class
            if ($booking->classes->count() - $requestAndPayoutCount == 1 &&
                $cancellableBookingClass['refund']) {
                
                if ($partialRefundAmount) {
                    $singleClassAmount = $cancellableBookingClass['amount'];
                    $amountToRefund += $cancellableBookingClass['amount'];
                    
                    // Double check even if there is partial refund
                    $remainingCents = $totalRefundableAmount - ($totalRefundedAndPayoutAmount + $singleClassAmount
                            + $booking->service_fee + $booking->stripe_fee);
                    
                    if ($remainingCents > 0) {
                        $singleClassAmount += $remainingCents;
                        $amountToRefund += $remainingCents;
                    }
                    
                } else {
                    // check for existing partial refunds
                    if ($refundRequests->where('amount', $partialRefundAmount)->first()) {
                        $singleClassAmount = $cancellableBookingClass['amount'];
                        $amountToRefund += $cancellableBookingClass['amount'];
                        
                        // Double check even if there is partial refund
                        $remainingCents = $totalRefundableAmount - ($totalRefundedAndPayoutAmount + $singleClassAmount
                                + $booking->service_fee + $booking->stripe_fee);
                        
                        if ($remainingCents > 0) {
                            $singleClassAmount += $remainingCents;
                            $amountToRefund += $remainingCents;
                        }
                    } else {
                        $singleClassAmount = $totalRefundableAmount - $totalRefundedAndPayoutAmount;
                        $amountToRefund += $totalRefundableAmount - $totalRefundedAndPayoutAmount;
                    }
                }
            } else if ($cancellableBookingClass['refund']) {
                $amountToRefund += $cancellableBookingClass['amount'];
                $singleClassAmount = $cancellableBookingClass['amount'];
            } else {
                $singleClassAmount = 0;
            }
            
            $totalRefundedAndPayoutAmount += $singleClassAmount;
            
            if ($cancellableBookingClass['refund']) {
                RefundRequest::create([
                    'booking_id' => $booking->id,
                    'lesson_class_id' => $cancellableBookingClass['id'],
                    'group' => $requestGroup,
                    'amount' => $singleClassAmount,
                    'request_reason' => 'Parent Cancelled Class',
                    'status' => 'granted',
                    'action_by' => 'parent'
                ]);
            }
            
            $requestAndPayoutCount++;
        }
        
        // whether Stripe Fee should be transfer to Tutor Stripe account
        $this->transferStripeFee($booking, $amountToRefund);
        
        // Refund Booking to User
        $refund = StripeController::refundCharge($booking, $chargeTxn, $amountToRefund, $booking->lesson->user);
        
        $refundTxn = $this->storeTransaction($booking, $refund);
        
        RefundRequest::where('booking_id', $booking->id)
            ->whereIn('lesson_class_id', Arr::pluck($cancellableBookingClasses, 'id'))
            ->update(['transaction_id' => $refundTxn->id]);
        
        
        if ($booking->classes->count() == $requestAndPayoutCount) {
            $booking->update([
                'refunded_amount' => $booking->refunded_amount + $amountToRefund,
                'status' => 'cancelled'
            ]);
        } else {
            $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund]);
        }
    }
    
    public function refundOnCancelClass($booking, $refundableClasses)
    {
        $requestGroup = uniqid();
        
        $chargeTxn = $booking->transactions->where('amount', $booking->amount)
            ->where('type', 'charge')->where('status', 'succeeded')->first();
        
        $totalRefundableAmount = $booking->amount;
        
        $refundRequests = RefundRequest::where('booking_id', $booking->id)
            ->where('status', '!=', 'decline')->get();
        $totalRequestedAmount = $refundRequests->sum('amount');
        
        $payouts = BookingClass::where('booking_id', $booking->id)
            ->where('payout_amount', '!=', 0)->get();
        $totalPayoutAmount = $payouts->sum('payout_amount');
        
        $totalRefundedAndPayoutAmount = $totalRequestedAmount + $totalPayoutAmount;
        
        $singleClassAmount = ClassHubHelper::roundCents($totalRefundableAmount / $booking->classes->count());
        
        $amountToRefund = 0;
        
        $requestAndPayoutCount = $refundRequests->count() + $payouts->count();
        
        foreach ($refundableClasses as $refundableClass) {
            
            // Make cents off adjustment on the last class
            if ($booking->classes->count() - $requestAndPayoutCount == 1) {
                $singleClassAmount = $totalRefundableAmount - $totalRefundedAndPayoutAmount;
                $amountToRefund += $totalRefundableAmount - $totalRefundedAndPayoutAmount;
            } else {
                $amountToRefund += $singleClassAmount;
            }
            
            $totalRefundedAndPayoutAmount += $singleClassAmount;
            
            RefundRequest::create([
                'booking_id' => $booking->id,
                'lesson_class_id' => $refundableClass,
                'group' => $requestGroup,
                'amount' => $singleClassAmount,
                'request_reason' => 'Teacher Cancelled Class',
                'status' => 'granted',
                'action_by' => 'tutor'
            ]);
            
            $requestAndPayoutCount++;
        }
        
        // whether Stripe Fee should be transfer to Tutor Stripe account
        $this->transferStripeFee($booking, $amountToRefund);
        
        // Refund Booking to User
        $refund = StripeController::refundCharge($booking, $chargeTxn, $amountToRefund, $booking->lesson->user);
        
        $refundTxn = $this->storeTransaction($booking, $refund);
        
        RefundRequest::where('booking_id', $booking->id)->whereIn('lesson_class_id', $refundableClasses)
            ->update(['transaction_id' => $refundTxn->id]);
        
        if ($booking->amount == ($booking->refunded_amount + $amountToRefund)) {
            $booking->update([
                'refunded_amount' => $booking->refunded_amount + $amountToRefund,
                'status' => 'cancelled'
            ]);
        } else {
            $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund]);
        }
    }
    
    public function getCancellableSingleClasses($booking)
    {
        $bookingDate = Carbon::parse($booking->created_at);
        $cancellableBookingClasses = [];
        $successMessages = [];
        $errorMessages = [];
        
        foreach ($booking->classes as $bookingClass) {
            
            if (!$bookingClass->is_refundable)
                continue;
            
            $class = $bookingClass->class;
            $classStartAt = Carbon::parse($class->date . ' ' . $class->start_time);
            
            // Class haven't started
            if ($classStartAt->isFuture()) {
                
                // CANCELLATION 7.2.2 Booking within 14days
                if ($bookingDate->diffInDays($classStartAt, false) <= 14) {
                    
                    array_push($cancellableBookingClasses,
                        [
                            '14days_rule' => true, 'refund' => true,
                            'id' => $bookingClass->lesson_class_id, 'amount' => 0
                        ]
                    );
                    
                    array_push($successMessages, $classStartAt->format('d/m/Y h:i A')
                        . ' class cancelled (Full refund)');
                }
                // CANCELLATION 7.2.1 Booking out of 14days
                // if ($bookingDate->diffInDays($classStartAt, false) > 14)
                else {
                    if (Carbon::now()->diffInHours($classStartAt, false) >= 12) {
                        array_push($cancellableBookingClasses,
                            [
                                '14days_rule' => true, 'refund' => true,
                                'id' => $bookingClass->lesson_class_id, 'amount' => 0
                            ]
                        );
                        array_push($successMessages, $classStartAt->format('d/m/Y h:i A')
                            . ' class cancelled (Full refund)');
                        
                    } else {
                        array_push($cancellableBookingClasses,
                            [
                                '14days_rule' => false, 'refund' => true,
                                'id' => $bookingClass->lesson_class_id, 'amount' => 0
                            ]
                        );
                        array_push($successMessages, $classStartAt->format('d/m/Y h:i A')
                            . ' class cancelled (Partial refund)');
                    }
                }
                
            } else {
                array_push($successMessages, 'Error : ' . $classStartAt->format('d/m/Y h:i A')
                    . ' class already started');
            }
            
        }
        
        return [$cancellableBookingClasses, $successMessages, $errorMessages];
    }
    
    public function getCancellableGroupTermClasses($booking)
    {
        $bookingDate = Carbon::parse($booking->created_at);
        
        $cancellableBookingClasses = [];
        $successMessages = [];
        $errorMessages = [];
        
        $firstClass = $booking->lesson->classes->first();
        $termGroupStartAt = Carbon::parse($firstClass->date . ' ' . $firstClass->start_time);
        
        foreach ($booking->classes as $bookingClass) {
            
            if (!$bookingClass->is_refundable)
                continue;
            
            $class = $bookingClass->class;
            $classStartAt = Carbon::parse($class->date . ' ' . $class->start_time);
            
            // Class haven't started
            if ($classStartAt->isFuture()) {
                
                // If Term group has started user get partial refund
                if ($termGroupStartAt->isPast()) {
                    array_push($cancellableBookingClasses,
                        [
                            '14days_rule' => true, 'refund' => true,
                            'id' => $bookingClass->lesson_class_id, 'amount' => 0
                        ]
                    );
                    array_push($successMessages, $classStartAt->format('d/m/Y h:i A')
                        . ' class cancelled (Full refund)');
                } // CANCELLATION 7.2.2 Booking within 14days
                else if ($bookingDate->diffInDays($termGroupStartAt, false) <= 14) {
                    
                    array_push($cancellableBookingClasses,
                        [
                            '14days_rule' => true, 'refund' => true,
                            'id' => $bookingClass->lesson_class_id, 'amount' => 0
                        ]
                    );
                    
                    array_push($successMessages, $classStartAt->format('d/m/Y h:i A')
                        . ' class cancelled (Full refund)');
                }
                // CANCELLATION 7.2.1 Booking out of 14days
                // if ($bookingDate->diffInDays($classStartAt, false) > 14)
                else {
                    if (Carbon::now()->diffInHours($classStartAt, false) >= 12) {
                        array_push($cancellableBookingClasses,
                            [
                                '14days_rule' => true, 'refund' => true,
                                'id' => $bookingClass->lesson_class_id, 'amount' => 0
                            ]
                        );
                        array_push($successMessages, $classStartAt->format('d/m/Y h:i A')
                            . ' class cancelled (Full refund)');
                        
                    } else {
                        array_push($cancellableBookingClasses,
                            [
                                '14days_rule' => false, 'refund' => true,
                                'id' => $bookingClass->lesson_class_id, 'amount' => 0
                            ]
                        );
                        array_push($successMessages, $classStartAt->format('d/m/Y h:i A')
                            . ' class cancelled (Partial refund)');
                    }
                }
            } else {
                array_push($errorMessages, 'Error : ' . $classStartAt->format('d/m/Y h:i A')
                    . ' class already started');
            }
            
        }
        
        return [$cancellableBookingClasses, $successMessages, $errorMessages];
    }
    
    public function updateCancelBookingData($booking, $cancellableBookingClasses)
    {
        try {
            
            BookingClass::where('booking_id', $booking->id)
                ->whereIn('lesson_class_id', $cancellableBookingClasses)
                ->update(['status' => 'cancelled', 'action_by' => 'parent']);
            
            $lesson = Lesson::findOrFail($booking->lesson_id);
            
            $firstClass = $lesson->classes->first();
            $firstClassStartAt = Carbon::parse($firstClass->date . ' ' . $firstClass->start_time);
            
            if ($lesson->type == 'single') {
                $lessonBookable = false;
                $classes = LessonClass::whereIn('id', $cancellableBookingClasses)->get();
                
                DB::beginTransaction();
                
                foreach ($classes as $class) {
                    $classStartAt = Carbon::parse($class->date . ' ' . $class->start_time);
                    
                    if ($classStartAt->isFuture()) {
                        $numBookings = (int)$class->num_bookings - 1;
                        $lessonBookable = true;
                        $class->update(['num_bookings' => $numBookings, 'bookable' => 1]);
                    }
                }
                
                if ($lessonBookable) {
                    $lesson->update(['status' => 'live', 'bookable' => 1]);
                }
                
                DB::commit();
                
            } else if ($lesson->type === 'subject') {
                DB::beginTransaction();
                
                $classes = LessonClass::whereIn('id', $cancellableBookingClasses)->get();
                
                foreach ($classes as $class) {
                    $class->update(['status' => 'cancelled', 'bookable' => 0]);
                }
                
                $lesson->update(['status' => 'cancelled', 'bookable' => 0]);
                
                DB::commit();
                
            } else {
                if ($firstClassStartAt->isFuture()) {
                    $numBookings = (int)$lesson->num_bookings - 1;
                    $lesson->update(['status' => 'live', 'bookable' => 1, 'num_bookings' => $numBookings]);
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getTraceAsString());
        }
    }
    
    
    public function transferStripeFee($booking, $refundableAmount)
    {
        $amountLeft = $booking->amount - ($booking->refunded_amount + $refundableAmount);
        
        if ($amountLeft >= 0 && $amountLeft <= $booking->stripe_fee) {
            
            $stripeFeeAmount = $amountLeft ? $amountLeft : $booking->stripe_fee;
            
            $transfer = StripeController::transferStripeFee($stripeFeeAmount, $booking, $booking->lesson->user);
            
            $this->storeTransaction($booking, $transfer);
            
            $booking->update(['stripe_fee_transferred' => 1]);
        }
    }
    
    public function updateBookingStatus($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $numClasses = $booking->classes->count();
            
            $numCancelled = $booking->classes->where('status', 'cancelled')->count();
            
            if ($numClasses == $numCancelled) {
                $booking->update(['status' => 'cancelled']);
            }
        } catch (\Exception $e) {
        }
    }
    
    public function rejectSubjectBooking(Request $request)
    {
        try {
            $message = Message::find($request->message_id);
            
            $message->update(['booking_response' => 2]);
            
            return response()->json([
                'status' => true,
                'messages' => ['Booking rejected'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => $e->getMessage()
            ]);
        }
        
    }
    
    
    public static function classReminder()
    {
        try {
            // Booking only with no or partial refund
            $bookings = Booking::where('stripe_fee_transferred', 0)
                ->where('status', 'completed')->get();
            
            foreach ($bookings as $booking) {
                $lesson = $booking->lesson;
                $bookingClasses = $booking->classes()->where('status', 'completed')->where('payout_amount', 0)
                    ->where('reminder_sent', 0)->get();
                
                if ($bookingClasses->count() && $lesson->status != 'cancelled' && $lesson->status != 'expired') {
                    $educatorClasses = [];
                    $reminderSent = [];
                    
                    foreach ($bookingClasses as $bookingClass) {
                        $class = $bookingClass->class;
                        $classStartAt = Carbon::parse($class->date . ' ' . $class->start_time);
                        $notifyStartAt = Carbon::parse($class->date . ' ' . $class->start_time)->subHours(2);
                        $notifyEndAt = Carbon::parse($class->date . ' ' . $class->start_time)->subHours(3);
                        
                        if ($classStartAt->isFuture() && !$bookingClass->reminder_sent &&
                            Carbon::now()->between($notifyStartAt, $notifyEndAt)) {
                            
                            $bookingClass->update(['reminder_sent' => 1]);
                            
                            if ($class->type == 'single') {
                                $job1 = new SendEmailJob($booking->user->email,
                                    new ClassReminder($booking->user, $lesson->user, $lesson, $class, $booking->user->email));
                                
                                array_push($educatorClasses, [
                                    'id' => $class->id,
                                    'type' => $lesson->type,
                                    'email' => $booking->lesson->user->email,
                                    'user' => $lesson->user,
                                    'lesson' => $lesson,
                                    'class' => $class,
                                ]);
                                
                                dispatch($job1);
                            } else {
                                $job1 = new SendEmailJob($booking->user->email,
                                    new TermClassReminder($booking->user, $lesson->user, $lesson, $class, $booking->user->email));
                                
                                array_push($educatorClasses, [
                                    'id' => $class->id,
                                    'type' => $lesson->type,
                                    'email' => $booking->lesson->user->email,
                                    'user' => $lesson->user,
                                    'lesson' => $lesson,
                                    'class' => $class,
                                ]);
                                
                                dispatch($job1);
                            }
                            
                        }
                    }
                    
                    // send educator email
                    foreach ($educatorClasses as $educatorClass) {
                        if (!in_array($educatorClass['id'], $reminderSent)) {
                            if ($educatorClass['type'] == 'single') {
                                $job = new SendEmailJob($educatorClass['email'],
                                    new ClassReminder($educatorClass['user'], $educatorClass['user'], $educatorClass['lesson'],
                                        $educatorClass['class'], $educatorClass['email']));
                                
                                dispatch($job);
                            } else {
                                $job = new SendEmailJob($educatorClass['email'],
                                    new TermClassReminder($educatorClass['user'], $educatorClass['user'], $educatorClass['lesson'],
                                        $educatorClass['class'], $educatorClass['email']));
                                
                                dispatch($job);
                            }
                            
                            array_push($reminderSent, $educatorClass['id']);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
    
    public function parentReceiptPDF($bookingId)
    {
        try {
            
            libxml_use_internal_errors(true);
            
            $booking = Booking::withTrashed()->findOrFail($bookingId);
            
            $transaction = json_decode(Transaction::whereBookingId($booking->id)->first()->txn_details);
            
            $lesson = Lesson::withTrashed()->findOrFail($booking->lesson_id);
            
            $classes = LessonClass::withTrashed()->whereIn('id', $booking->classes
                ->pluck('lesson_class_id')->toArray())->get();
            
            $educator = User::withTrashed()->findOrFail($lesson->user_id);
            
            $parent = User::withTrashed()->findOrFail($booking->user_id);
            
            $pdf = PDF::loadView('pdf.parent-receipt', compact('booking', 'transaction', 'lesson',
                'parent', 'educator', 'classes'));
            $pdf->setPaper('a5');
            
            return $pdf->download('Receipt-' . ClassHubHelper::getbookingCode($booking) . '.pdf');
            
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    
    public function educatorReceiptPDF($bookingId, $classId)
    {
        try {
            
            libxml_use_internal_errors(true);
            
            $booking = Booking::withTrashed()->findOrFail($bookingId);
            
            $bookingClass = BookingClass::where('booking_id', $booking->id)
                ->where('lesson_class_id', $classId)->first();
            
            $class = LessonClass::withTrashed()->findOrFail($classId);
            
            $lesson = Lesson::withTrashed()->findOrFail($booking->lesson_id);
            
            $educator = User::withTrashed()->findOrFail($lesson->user_id);
            
            $parent = $booking->user;
            
            $payoutAmount = $bookingClass->payout_amount;
            
            $singleClassAmount = ClassHubHelper::roundCents(($booking->amount - $booking->service_fee)
                / $booking->classes->count());
            
            $serviceCharge = $singleClassAmount - $payoutAmount;
            
            $pdf = PDF::loadView('pdf.educator-receipt', compact('booking', 'bookingClass', 'lesson',
                'class', 'parent', 'educator', 'payoutAmount', 'singleClassAmount', 'serviceCharge'));
            
            $pdf->setPaper('a5');
            
            return $pdf->download('Receipt-' . ClassHubHelper::getbookingCode($booking) . '.pdf');
            
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    
    public function educatorVatReceiptPDF($bookingId, $classId)
    {
        try {
            
            libxml_use_internal_errors(true);
            
            $booking = Booking::withTrashed()->findOrFail($bookingId);
            
            $bookingClass = BookingClass::where('booking_id', $booking->id)
                ->where('lesson_class_id', $classId)->first();
            
            $class = LessonClass::withTrashed()->findOrFail($classId);
            
            $lesson = Lesson::withTrashed()->findOrFail($booking->lesson_id);
            
            $educator = User::withTrashed()->findOrFail($lesson->user_id);
            
            $transaction = Transaction::where('id', $bookingClass->transaction_id)->first();
            
            $parent = $booking->user;
            
            $payoutAmount = $bookingClass->payout_amount;
            
            $singleClassAmount = ClassHubHelper::roundCents(($booking->amount - $booking->service_fee)
                / $booking->classes->count());
            
            $vatServiceFee = ClassHubHelper::roundCents($booking->service_fee * 0.23);
            
            $baseServiceFee = $booking->service_fee;
            
            $serviceCharge = $baseServiceFee + $vatServiceFee;
            
            $pdf = PDF::loadView('pdf.educator-vat-invoice', compact('booking', 'bookingClass', 'lesson',
                'class', 'parent', 'educator', 'payoutAmount', 'singleClassAmount', 'serviceCharge', 'baseServiceFee',
                'vatServiceFee', 'transaction'));
            
            $pdf->setPaper('a5');
            
            return $pdf->download('VAT-Receipt-' . ClassHubHelper::getbookingCode($booking) . '.pdf');
            
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
