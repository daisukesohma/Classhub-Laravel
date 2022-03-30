<?php

namespace App\Http\Controllers;

use App\Booking;
use App\BookingClass;
use App\Educator;
use App\ErrorLog;
use App\Helpers\ClassHubHelper;
use App\Lesson;
use App\LessonClass;
use App\RefundRequest;
use App\Setting;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Stripe\Account;
use Stripe\Balance;
use Stripe\Charge;
use Stripe\File;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Stripe\Token;

class TestController extends Controller
{
    public function run(Request $request, $num = 1)
    {
        $teacher = $this->createTeacher(Carbon::now()->getTimestamp());
        $parents = [];
        
        for ($i = 1; $i < 4; $i++) {
            array_push($parents, $this->createStudents($i, Carbon::now()->getTimestamp()));
        }
        
        echo '<p>Teacher: ' . $teacher->name . '</p>';
        
        foreach ($parents as $parent) {
            echo '<p>Student : ' . $parent->name . '</p>';
        }
        
        if ($num == 1) {
            $this->test1($teacher, $parents);
            $this->test1($teacher, $parents, true);
            $this->test1($teacher, $parents, true);
            $this->test1($teacher, $parents, true);
        }
        
        if ($num == 2) {
            $this->test2($teacher, $parents);
            $this->test2($teacher, $parents, true);
            $this->test2($teacher, $parents, true);
            $this->test2($teacher, $parents, true);
        }
        
        if ($num == 3) {
            $this->test3($teacher, $parents);
            $this->test3($teacher, $parents, true);
            $this->test3($teacher, $parents, true);
            $this->test3($teacher, $parents, true);
        }
        
        if ($num == 4) {
            $this->test4($teacher, $parents);
            $this->test4($teacher, $parents, true);
            $this->test4($teacher, $parents, true);
            $this->test4($teacher, $parents, true);
        }
        
        if ($num == 5) {
            $this->test5($teacher, $parents);
            $this->test5($teacher, $parents, true);
            $this->test5($teacher, $parents, true);
            $this->test5($teacher, $parents, true);
        }
        
        if ($num == 6) {
            $this->test6($teacher, $parents);
            $this->test6($teacher, $parents, true);
            $this->test6($teacher, $parents, true);
            $this->test6($teacher, $parents, true);
        }
        
        if ($num == 7) {
            $this->test7($teacher, $parents);
            $this->test7($teacher, $parents, true);
            $this->test7($teacher, $parents, true);
            $this->test7($teacher, $parents, true);
        }
        
        if ($num == 8) {
            $this->test8($teacher, $parents);
            $this->test8($teacher, $parents, true);
            $this->test8($teacher, $parents, true);
            $this->test8($teacher, $parents, true);
        }
        
        if ($num == 9) {
            $this->test9($teacher, $parents);
            $this->test9($teacher, $parents, true);
            $this->test9($teacher, $parents, true);
            $this->test9($teacher, $parents, true);
        }
        
        if ($num == 10) {
            $this->test10($teacher, $parents);
            $this->test10($teacher, $parents, true);
            $this->test10($teacher, $parents, true);
            $this->test10($teacher, $parents, true);
        }
        
        if ($num == 11) {
            $this->test11($teacher, $parents);
            $this->test11($teacher, $parents, true);
            $this->test11($teacher, $parents, true);
            $this->test11($teacher, $parents, true);
        }
        
        if ($num == 12) {
            $this->test12($teacher, $parents);
            $this->test12($teacher, $parents, true);
            $this->test12($teacher, $parents, true);
            $this->test12($teacher, $parents, true);
        }
        
        if ($num == 13) {
            $this->test13($teacher, $parents);
            $this->test13($teacher, $parents, true);
            $this->test13($teacher, $parents, true);
            $this->test13($teacher, $parents, true);
        }
    }
    
    public function test1($teacher, $parents, $random = false)
    {
        echo '<p>================== TEST 1 ==============</p>';
        echo '<h3>Test case: Book a single class. Change class date to yesterday and request payout</h3>';
        
        $lesson = $this->createSingleClass($teacher, 1, $random);
        
        list($booking, $charge) = $this->bookLesson($lesson, $teacher, $parents[0]);
        
        foreach ($lesson->classes as $class) {
            $class->update(['date' => Carbon::now()->subDays(2)]);
        }
        
        $booking->update(['created_at' => Carbon::now()->subDays(rand(15, 30))->format('Y-m-d H:i:s')]);
        
        $payout = $this->testPayout($booking);
        
        echo '<p><strong>Results : </strong></p>';
        echo '<p>Booking Date : ' . Carbon::parse($booking->created_at)->format('d-m-Y') . '</p>';
        echo '<p>Payout Date : ' . Carbon::now()->format('d-m-Y') . '</p>';
        if ($payout) {
            echo '<p>Payout ID : ' . $payout->id . '</p>';
            echo '<p>Payout Amount : ' . $payout->amount . '</p>';
            
        } else {
            echo '<p>Payout Failed</p>';
        }
        
        echo '<p><strong>Booking Details : </strong></p>';
        echo '<p>Class Name : ' . $lesson->name . '</p>';
        echo '<p>Number of Classes : ' . $lesson->classes->count() . '</p>';
        echo '<p>Student Name: ' . $parents[0]->name . '</p>';
        echo '<p>Booking Code : ' . ClassHubHelper::getbookingCode($booking) . '</p>';
        
        echo '<p><strong>Payment Details : </strong></p>';
        echo '<p>Class Price : ' . ($booking->amount - $booking->service_fee) . '</p>';
        echo '<p>Booking Amount : ' . $booking->amount . '</p>';
        echo '<p>Application Fee : ' . $booking->application_fee . '</p>';
        echo '<p>Service Fee : ' . $booking->service_fee . '</p>';
        echo '<p>Stripe Fee : ' . $booking->stripe_fee . '</p>';
        echo '<p>Charge ID : ' . $charge->id . '</p>';
        echo '<p>Charge Amount : ' . $charge->amount . '</p>';
        
        echo '<p><strong>Displayed to Provider : </strong></p>';
        echo '<p>Provider Earning : ' . $this->getEarningAmount($booking) . '</p>';
        echo '<p>Classhub Earning : ' . $this->getCommissionAmount($booking) . '</p>';
        
        echo '<p>================== TEST 1 END ==============</p>';
    }
    
    public function test2($teacher, $parents, $random = false)
    {
        echo '<p>================== TEST 2 ==============</p>';
        echo '<h3>Test case: Book a single class. BOOKING OUT OF 14 days.
                Cancel requested before 14 day</h3>';
        
        try {
            $lesson = $this->createSingleClass($teacher, 1, $random);
            
            list($booking, $charge) = $this->bookLesson($lesson, $teacher, $parents[1]);
            
            $lesson->classes->first()->update(['date' => Carbon::now()->addDays(15)]);
            
            $booking->update(['created_at' => Carbon::now()->subDays(rand(15, 30))->format('Y-m-d H:i:s')]);
            
            $bookingCtrlr = new BookingController();
            
            list($cancellableBookingClasses, $successMessages, $errorMessages)
                = $bookingCtrlr->getCancellableSingleClasses($booking);
            
            $requestGroup = uniqid();
            
            // Get the Charge transaction of booking
            $chargeTxn = $booking->transactions->where('amount', $booking->amount)
                ->where('type', 'charge')->where('status', 'succeeded')->first();
            
            foreach ($cancellableBookingClasses as $index => $cancellableBookingClass) {
                // 14 days rule applied
                if ($cancellableBookingClass['14days_rule'] && $cancellableBookingClass['refund']) {
                    $singleClassPrice = ClassHubHelper::roundCents($booking->amount / $booking->classes->count());
                } else if ($cancellableBookingClass['refund']) {
                    $bookingAmount = $booking->amount - ($booking->service_fee + $booking->stripe_fee);
                    $singleClassPrice = ClassHubHelper::roundCents($bookingAmount / $booking->classes->count());
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
                if ($booking->classes->count() - $requestAndPayoutCount == 1 && $cancellableBookingClass['refund']) {
                    $singleClassAmount = $totalRefundableAmount - $totalRefundedAndPayoutAmount;
                    $amountToRefund += $totalRefundableAmount - $totalRefundedAndPayoutAmount;
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
            
            $bookingCtrlr = new BookingController();
            
            // whether Stripe Fee should be transfer to Tutor Stripe account
            $bookingCtrlr->transferStripeFee($booking, $amountToRefund);
            
            // Refund Booking to User
            $refund = StripeController::refundCharge($chargeTxn, $amountToRefund, $teacher);
            
            $refundTxn = $bookingCtrlr->storeTransaction($booking, $refund);
            
            RefundRequest::where('booking_id', $booking->id)
                ->whereIn('lesson_class_id', Arr::pluck($cancellableBookingClasses, 'id'))
                ->update(['transaction_id' => $refundTxn->id]);
            
            
            if ($booking->amount == ($booking->refunded_amount + $amountToRefund)) {
                $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund,
                    'status' => 'cancelled']);
            } else {
                $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund]);
            }
            
            echo '<p><strong>Results : </strong></p>';
            echo '<p>Booking Date : ' . Carbon::parse($booking->created_at)->format('d-m-Y') . '</p>';
            echo '<p>Cancel Date : ' . Carbon::now()->format('d-m-Y') . '</p>';
            echo '<p>Refund ID : ' . ($refund ? $refund->id : '-') . '</p>';
            echo '<p>Refund Amount : ' . ($refund ? $refund->amount : 0) . '</p>';
            echo '<p>Class Dates : </p>';
            echo '<p>' . implode('<br>', $successMessages) . '</p>';
            
            echo '<p><strong>Booking Details : </strong></p>';
            echo '<p>Class Name : ' . $lesson->name . '</p>';
            echo '<p>Number of Classes : ' . $lesson->classes->count() . '</p>';
            echo '<p>Student Name: ' . $parents[0]->name . '</p>';
            echo '<p>Booking Code : ' . ClassHubHelper::getbookingCode($booking) . '</p>';
            
            echo '<p><strong>Payment Details : </strong></p>';
            echo '<p>Class Price : ' . ($booking->amount - $booking->service_fee) . '</p>';
            echo '<p>Booking Amount : ' . $booking->amount . '</p>';
            echo '<p>Application Fee : ' . $booking->application_fee . '</p>';
            echo '<p>Service Fee : ' . $booking->service_fee . '</p>';
            echo '<p>Stripe Fee : ' . $booking->stripe_fee . '</p>';
            echo '<p>Charge ID : ' . $charge->id . '</p>';
            echo '<p>Charge Amount : ' . $charge->amount . '</p>';
            
            echo '<p><strong>Displayed to Provider : </strong></p>';
            echo '<p>Provider Earning : ' . $this->getEarningAmount($booking) . '</p>';
            echo '<p>Classhub Earning : ' . $this->getCommissionAmount($booking) . '</p>';
            
        } catch (\Exception $e) {
            dump($e->getTrace());
        }
        
        echo '<p>================== TEST 2 END ==============</p>';
        
    }
    
    public function test3($teacher, $parents, $random = false)
    {
        echo '<p>================== TEST 3 ==============</p>';
        echo '<h3>Test case: Book a single class. BOOKING OUT OF 14 days.
                Cancel requested after 14 day but before 12 hour</h3>';
        
        try {
            $lesson = $this->createSingleClass($teacher, 1, $random);
            
            list($booking, $charge) = $this->bookLesson($lesson, $teacher, $parents[1]);
            
            $booking->update(['created_at' => Carbon::now()->subDays(rand(15, 30))->format('Y-m-d H:i:s')]);
            
            $lesson->classes->first()->update([
                'date' => Carbon::now()->addDay()->format('Y-m-d'),
            ]);
            
            $bookingCtrlr = new BookingController();
            
            list($cancellableBookingClasses, $successMessages, $errorMessages)
                = $bookingCtrlr->getCancellableSingleClasses($booking);
            
            $requestGroup = uniqid();
            
            $refund = null;
            
            // Get the Charge transaction of booking
            $chargeTxn = $booking->transactions->where('amount', $booking->amount)
                ->where('type', 'charge')->where('status', 'succeeded')->first();
            
            foreach ($cancellableBookingClasses as $index => $cancellableBookingClass) {
                // 14 days rule applied
                if ($cancellableBookingClass['14days_rule'] && $cancellableBookingClass['refund']) {
                    $singleClassPrice = ClassHubHelper::roundCents($booking->amount / $booking->classes->count());
                } else if ($cancellableBookingClass['refund']) {
                    $bookingAmount = $booking->amount - ($booking->service_fee + $booking->stripe_fee);
                    $singleClassPrice = ClassHubHelper::roundCents($bookingAmount / $booking->classes->count());
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
                if ($booking->classes->count() - $requestAndPayoutCount == 1 && $cancellableBookingClass['refund']) {
                    $singleClassAmount = $totalRefundableAmount - $totalRefundedAndPayoutAmount;
                    $amountToRefund += $totalRefundableAmount - $totalRefundedAndPayoutAmount;
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
            
            if ($amountToRefund) {
                // whether Stripe Fee should be transfer to Tutor Stripe account
                $bookingCtrlr->transferStripeFee($booking, $amountToRefund);
                
                // Refund Booking to User
                $refund = StripeController::refundCharge($chargeTxn, $amountToRefund, $teacher);
                
                $refundTxn = $bookingCtrlr->storeTransaction($booking, $refund);
                
                RefundRequest::where('booking_id', $booking->id)
                    ->whereIn('lesson_class_id', Arr::pluck($cancellableBookingClasses, 'id'))
                    ->update(['transaction_id' => $refundTxn->id]);
                
                
                if ($booking->amount == ($booking->refunded_amount + $amountToRefund)) {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund,
                        'status' => 'cancelled']);
                } else {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund]);
                }
            }
            
            
            echo '<p><strong>Results : </strong></p>';
            echo '<p>Booking Date : ' . Carbon::parse($booking->created_at)->format('d-m-Y') . '</p>';
            echo '<p>Cancel Date : ' . Carbon::now()->format('d-m-Y') . '</p>';
            echo '<p>Refund ID : ' . ($refund ? $refund->id : '-') . '</p>';
            echo '<p>Refund Amount : ' . ($refund ? $refund->amount : 0) . '</p>';
            echo '<p>Class Dates : </p>';
            echo '<p>' . implode('<br>', $successMessages) . '</p>';
            
            echo '<p><strong>Booking Details : </strong></p>';
            echo '<p>Class Name : ' . $lesson->name . '</p>';
            echo '<p>Number of Classes : ' . $lesson->classes->count() . '</p>';
            echo '<p>Student Name: ' . $parents[0]->name . '</p>';
            echo '<p>Booking Code : ' . ClassHubHelper::getbookingCode($booking) . '</p>';
            
            echo '<p><strong>Payment Details : </strong></p>';
            echo '<p>Class Price : ' . ($booking->amount - $booking->service_fee) . '</p>';
            echo '<p>Booking Amount : ' . $booking->amount . '</p>';
            echo '<p>Application Fee : ' . $booking->application_fee . '</p>';
            echo '<p>Service Fee : ' . $booking->service_fee . '</p>';
            echo '<p>Stripe Fee : ' . $booking->stripe_fee . '</p>';
            echo '<p>Charge ID : ' . $charge->id . '</p>';
            echo '<p>Charge Amount : ' . $charge->amount . '</p>';
            
            echo '<p><strong>Displayed to Provider : </strong></p>';
            echo '<p>Provider Earning : ' . $this->getEarningAmount($booking) . '</p>';
            echo '<p>Classhub Earning : ' . $this->getCommissionAmount($booking) . '</p>';
            
        } catch (\Exception $e) {
            dump($e->getTrace());
        }
        
        echo '<p>================== TEST 3 END ==============</p>';
        
    }
    
    public function test4($teacher, $parents, $random = false)
    {
        echo '<p>================== TEST 4 ==============</p>';
        echo '<h3>Test case: Book a single class. BOOKING OUT OF 14 days.
                 Cancel requested after 14 day and before class start</h3>';
        
        try {
            $lesson = $this->createSingleClass($teacher, 1, $random);
            
            list($booking, $charge) = $this->bookLesson($lesson, $teacher, $parents[1]);
            
            $booking->update(['created_at' => Carbon::now()->subDays(rand(15, 30))->format('Y-m-d H:i:s')]);
            
            $firstLesson = $lesson->classes->first();
            
            $firstLesson->update([
                'date' => Carbon::parse($firstLesson->date . ' ' . $firstLesson->start_time)
                    ->addHours(5)->format('Y-m-d'),
                'start_time' => Carbon::parse($firstLesson->date . ' ' . $firstLesson->start_time)
                    ->addHours(5)->format('H:i:s'),
                'end_time' => Carbon::parse($firstLesson->date . ' ' . $firstLesson->end_time)
                    ->addHours(6)->format('H:i:s'),
            ]);
            
            $bookingCtrlr = new BookingController();
            
            //$booking = Booking::findOrFail($booking->id);
            
            list($cancellableBookingClasses, $successMessages, $errorMessages)
                = $bookingCtrlr->getCancellableSingleClasses($booking);
            
            $requestGroup = uniqid();
            $partialRefundAmount = 0;
            $refund = null;
            
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
                    } else {
                        // check for existing partial refunds
                        if ($refundRequests->where('amount', $partialRefundAmount)->first()) {
                            $singleClassAmount = $cancellableBookingClass['amount'];
                            $amountToRefund += $cancellableBookingClass['amount'];
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
            
            if ($amountToRefund) {
                // whether Stripe Fee should be transfer to Tutor Stripe account
                $bookingCtrlr->transferStripeFee($booking, $amountToRefund);
                
                // Refund Booking to User
                $refund = StripeController::refundCharge($chargeTxn, $amountToRefund, $teacher);
                
                $refundTxn = $bookingCtrlr->storeTransaction($booking, $refund);
                
                RefundRequest::where('booking_id', $booking->id)
                    ->whereIn('lesson_class_id', Arr::pluck($cancellableBookingClasses, 'id'))
                    ->update(['transaction_id' => $refundTxn->id]);
                
                
                if ($booking->amount == ($booking->refunded_amount + $amountToRefund)) {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund,
                        'status' => 'cancelled']);
                } else {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund]);
                }
            }
            
            
            echo '<p><strong>Results : </strong></p>';
            echo '<p>Booking Date : ' . Carbon::parse($booking->created_at)->format('d-m-Y') . '</p>';
            echo '<p>Cancel Date : ' . Carbon::now()->format('d-m-Y') . '</p>';
            echo '<p>Refund ID : ' . ($refund ? $refund->id : '-') . '</p>';
            echo '<p>Refund Amount : ' . ($refund ? $refund->amount : 0) . '</p>';
            echo '<p>Class Dates : </p>';
            echo '<p>' . implode('<br>', $successMessages) . '</p>';
            
            echo '<p><strong>Booking Details : </strong></p>';
            echo '<p>Class Name : ' . $lesson->name . '</p>';
            echo '<p>Number of Classes : ' . $lesson->classes->count() . '</p>';
            echo '<p>Student Name: ' . $parents[0]->name . '</p>';
            echo '<p>Booking Code : ' . ClassHubHelper::getbookingCode($booking) . '</p>';
            
            echo '<p><strong>Payment Details : </strong></p>';
            echo '<p>Class Price : ' . ($booking->amount - $booking->service_fee) . '</p>';
            echo '<p>Booking Amount : ' . $booking->amount . '</p>';
            echo '<p>Application Fee : ' . $booking->application_fee . '</p>';
            echo '<p>Service Fee : ' . $booking->service_fee . '</p>';
            echo '<p>Stripe Fee : ' . $booking->stripe_fee . '</p>';
            echo '<p>Charge ID : ' . $charge->id . '</p>';
            echo '<p>Charge Amount : ' . $charge->amount . '</p>';
            
            echo '<p><strong>Displayed to Provider : </strong></p>';
            echo '<p>Provider Earning : ' . $this->getEarningAmount($booking) . '</p>';
            echo '<p>Classhub Earning : ' . $this->getCommissionAmount($booking) . '</p>';
            
        } catch (\Exception $e) {
            dump($e->getTrace());
        }
        
        echo '<p>================== TEST 4 END ==============</p>';
        
    }
    
    public function test5($teacher, $parents, $random = false)
    {
        
        echo '<p>================== TEST 5 ==============</p>';
        echo '<h3>Test case: Book a single class. BOOKING WITHIN 14 days.
                Cancel requested before class start</h3>';
        
        try {
            $lesson = $this->createSingleClass($teacher, 1, $random);
            
            list($booking, $charge) = $this->bookLesson($lesson, $teacher, $parents[1]);
            
            $booking->update(['created_at' => Carbon::now()->subDays(rand(1, 14))->format('Y-m-d H:i:s')]);
            
            $lesson->classes->first()->update([
                'start_time' => Carbon::now()->addHours(2)->format('H:i:s'),
                'end_time' => Carbon::now()->addHours(3)->format('H:i:s'),
            ]);
            
            $bookingCtrlr = new BookingController();
            
            list($cancellableBookingClasses, $successMessages, $errorMessages)
                = $bookingCtrlr->getCancellableSingleClasses($booking);
            
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
                    } else {
                        // check for existing partial refunds
                        if ($refundRequests->where('amount', $partialRefundAmount)->first()) {
                            $singleClassAmount = $cancellableBookingClass['amount'];
                            $amountToRefund += $cancellableBookingClass['amount'];
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
            
            if ($amountToRefund) {
                // whether Stripe Fee should be transfer to Tutor Stripe account
                $bookingCtrlr->transferStripeFee($booking, $amountToRefund);
                
                // Refund Booking to User
                $refund = StripeController::refundCharge($chargeTxn, $amountToRefund, $teacher);
                
                $refundTxn = $bookingCtrlr->storeTransaction($booking, $refund);
                
                RefundRequest::where('booking_id', $booking->id)
                    ->whereIn('lesson_class_id', Arr::pluck($cancellableBookingClasses, 'id'))
                    ->update(['transaction_id' => $refundTxn->id]);
                
                
                if ($booking->amount == ($booking->refunded_amount + $amountToRefund)) {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund,
                        'status' => 'cancelled']);
                } else {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund]);
                }
            }
            
            
            echo '<p><strong>Results : </strong></p>';
            echo '<p>Booking Date : ' . Carbon::parse($booking->created_at)->format('d-m-Y') . '</p>';
            echo '<p>Cancel Date : ' . Carbon::now()->format('d-m-Y') . '</p>';
            echo '<p>Refund ID : ' . ($refund ? $refund->id : '-') . '</p>';
            echo '<p>Refund Amount : ' . ($refund ? $refund->amount : 0) . '</p>';
            echo '<p>Class Dates : </p>';
            echo '<p>' . implode('<br>', $successMessages) . '</p>';
            
            echo '<p><strong>Booking Details : </strong></p>';
            echo '<p>Class Name : ' . $lesson->name . '</p>';
            echo '<p>Number of Classes : ' . $lesson->classes->count() . '</p>';
            echo '<p>Student Name: ' . $parents[0]->name . '</p>';
            echo '<p>Booking Code : ' . ClassHubHelper::getbookingCode($booking) . '</p>';
            
            echo '<p><strong>Payment Details : </strong></p>';
            echo '<p>Class Price : ' . ($booking->amount - $booking->service_fee) . '</p>';
            echo '<p>Booking Amount : ' . $booking->amount . '</p>';
            echo '<p>Application Fee : ' . $booking->application_fee . '</p>';
            echo '<p>Service Fee : ' . $booking->service_fee . '</p>';
            echo '<p>Stripe Fee : ' . $booking->stripe_fee . '</p>';
            echo '<p>Charge ID : ' . $charge->id . '</p>';
            echo '<p>Charge Amount : ' . $charge->amount . '</p>';
            
            echo '<p><strong>Displayed to Provider : </strong></p>';
            echo '<p>Provider Earning : ' . $this->getEarningAmount($booking) . '</p>';
            echo '<p>Classhub Earning : ' . $this->getCommissionAmount($booking) . '</p>';
            
        } catch (\Exception $e) {
            dump($e->getTrace());
        }
        
        echo '<p>================== TEST 5 END ==============</p>';
        
    }
    
    public function test6($teacher, $parents, $random = false)
    {
        
        echo '<p>================== TEST 6  ==============</p>';
        echo '<h3>Test case: Book a single class. Class started and cancel failed</h3>';
        
        try {
            $lesson = $this->createSingleClass($teacher, 1, $random);
            
            list($booking, $charge) = $this->bookLesson($lesson, $teacher, $parents[1]);
            
            $booking->update(['created_at' => Carbon::now()->subDays(rand(15, 30))->format('Y-m-d H:i:s')]);
            
            $lesson->classes->first()->update([
                'start_time' => Carbon::now()->subHours(2)->format('H:i:s'),
                'end_time' => Carbon::now()->subHours(3)->format('H:i:s'),
            ]);
            
            $bookingCtrlr = new BookingController();
            
            list($cancellableBookingClasses, $successMessages, $errorMessages)
                = $bookingCtrlr->getCancellableSingleClasses($booking);
            
            $requestGroup = uniqid();
            $partialRefundAmount = 0;
            $refund = null;
            
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
                    } else {
                        // check for existing partial refunds
                        if ($refundRequests->where('amount', $partialRefundAmount)->first()) {
                            $singleClassAmount = $cancellableBookingClass['amount'];
                            $amountToRefund += $cancellableBookingClass['amount'];
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
            
            if ($amountToRefund) {
                // whether Stripe Fee should be transfer to Tutor Stripe account
                $bookingCtrlr->transferStripeFee($booking, $amountToRefund);
                
                // Refund Booking to User
                $refund = StripeController::refundCharge($chargeTxn, $amountToRefund, $teacher);
                
                $refundTxn = $bookingCtrlr->storeTransaction($booking, $refund);
                
                RefundRequest::where('booking_id', $booking->id)
                    ->whereIn('lesson_class_id', Arr::pluck($cancellableBookingClasses, 'id'))
                    ->update(['transaction_id' => $refundTxn->id]);
                
                
                if ($booking->amount == ($booking->refunded_amount + $amountToRefund)) {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund,
                        'status' => 'cancelled']);
                } else {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund]);
                }
            }
            
            
            echo '<p><strong>Results : </strong></p>';
            echo '<p>Booking Date : ' . Carbon::parse($booking->created_at)->format('d-m-Y') . '</p>';
            echo '<p>Cancel Date : ' . Carbon::now()->format('d-m-Y') . '</p>';
            echo '<p>Refund ID : ' . ($refund ? $refund->id : '-') . '</p>';
            echo '<p>Refund Amount : ' . ($refund ? $refund->amount : 0) . '</p>';
            echo '<p>Class Dates : </p>';
            echo '<p>' . implode('<br>', $successMessages) . '</p>';
            
            echo '<p><strong>Booking Details : </strong></p>';
            echo '<p>Class Name : ' . $lesson->name . '</p>';
            echo '<p>Number of Classes : ' . $lesson->classes->count() . '</p>';
            echo '<p>Student Name: ' . $parents[0]->name . '</p>';
            echo '<p>Booking Code : ' . ClassHubHelper::getbookingCode($booking) . '</p>';
            
            echo '<p><strong>Payment Details : </strong></p>';
            echo '<p>Class Price : ' . ($booking->amount - $booking->service_fee) . '</p>';
            echo '<p>Booking Amount : ' . $booking->amount . '</p>';
            echo '<p>Application Fee : ' . $booking->application_fee . '</p>';
            echo '<p>Service Fee : ' . $booking->service_fee . '</p>';
            echo '<p>Stripe Fee : ' . $booking->stripe_fee . '</p>';
            echo '<p>Charge ID : ' . $charge->id . '</p>';
            echo '<p>Charge Amount : ' . $charge->amount . '</p>';
            
            echo '<p><strong>Displayed to Provider : </strong></p>';
            echo '<p>Provider Earning : ' . $this->getEarningAmount($booking) . '</p>';
            echo '<p>Classhub Earning : ' . $this->getCommissionAmount($booking) . '</p>';
            
        } catch (\Exception $e) {
            dump($e->getTrace());
        }
        
        echo '<p>================== TEST 6 END ==============</p>';
        
    }
    
    // Group/term classes
    public function test7($teacher, $parents, $random = false)
    {
        echo '<p>================== TEST 7 ==============</p>';
        echo '<h3>Test case: Book a group/term class.
                Payout after 1 class done</h3>';
        
        $lesson = $this->createGroupClass($teacher, $random ? rand(2, 10) : 10, $random);
        
        list($booking, $charge) = $this->bookLesson($lesson, $teacher, $parents[0]);
        
        $booking->update(['created_at' => Carbon::now()->subDays(rand(15, 30))->format('Y-m-d H:i:s')]);
        
        foreach ($lesson->classes as $class) {
            $class->update(['date' => Carbon::now()->subDays(2)]);
        }
        
        $payout = $this->testPayout($booking);
        
        
        echo '<p><strong>Results : </strong></p>';
        echo '<p>Booking Date : ' . Carbon::parse($booking->created_at)->format('d-m-Y') . '</p>';
        echo '<p>Payout Date : ' . Carbon::now()->format('d-m-Y') . '</p>';
        if ($payout) {
            echo '<p>Payout ID : ' . $payout->id . '</p>';
            echo '<p>Payout Amount : ' . $payout->amount . '</p>';
            
        } else {
            echo '<p>Payout Failed</p>';
        }
        
        echo '<p><strong>Booking Details : </strong></p>';
        echo '<p>Class Name : ' . $lesson->name . '</p>';
        echo '<p>Number of Classes : ' . $lesson->classes->count() . '</p>';
        echo '<p>Student Name: ' . $parents[0]->name . '</p>';
        echo '<p>Booking Code : ' . ClassHubHelper::getbookingCode($booking) . '</p>';
        
        echo '<p><strong>Payment Details : </strong></p>';
        echo '<p>Class Price : ' . ($booking->amount - $booking->service_fee) . '</p>';
        echo '<p>Booking Amount : ' . $booking->amount . '</p>';
        echo '<p>Application Fee : ' . $booking->application_fee . '</p>';
        echo '<p>Service Fee : ' . $booking->service_fee . '</p>';
        echo '<p>Stripe Fee : ' . $booking->stripe_fee . '</p>';
        echo '<p>Charge ID : ' . $charge->id . '</p>';
        echo '<p>Charge Amount : ' . $charge->amount . '</p>';
        
        echo '<p><strong>Displayed to Provider : </strong></p>';
        echo '<p>Provider Earning : ' . $this->getEarningAmount($booking) . '</p>';
        echo '<p>Classhub Earning : ' . $this->getCommissionAmount($booking) . '</p>';
        
        echo '<p>================== TEST 7 END ==============</p>';
    }
    
    public function test8($teacher, $parents, $random = false)
    {
        echo '<p>================== TEST 8 ==============</p>';
        echo '<h3>Test case: Book term/group class. BOOKING OUT OF 14 days.
                Cancel requested before 14 day</h3>';
        
        try {
            
            $lesson = $this->createGroupClass($teacher, $random ? rand(2, 10) : 10, $random);
            
            foreach ($lesson->classes as $class) {
                $date = Carbon::parse($class->date);
                $class->update(['date' => $date->addDays(15)->format('Y-m-d')]);
            }
            
            list($booking, $charge) = $this->bookLesson($lesson, $teacher, $parents[1]);
            
            $booking->update(['created_at' => Carbon::now()->subDays(rand(15, 30))->format('Y-m-d H:i:s')]);
            
            $bookingCtrlr = new BookingController();
            
            list($cancellableBookingClasses, $successMessages, $errorMessages)
                = $bookingCtrlr->getCancellableGroupTermClasses($booking);
            
            $requestGroup = uniqid();
            
            // Get the Charge transaction of booking
            $chargeTxn = $booking->transactions->where('amount', $booking->amount)
                ->where('type', 'charge')->where('status', 'succeeded')->first();
            
            foreach ($cancellableBookingClasses as $index => $cancellableBookingClass) {
                // 14 days rule applied
                if ($cancellableBookingClass['14days_rule'] && $cancellableBookingClass['refund']) {
                    $singleClassPrice = ClassHubHelper::roundCents($booking->amount / $booking->classes->count());
                } else if ($cancellableBookingClass['refund']) {
                    $bookingAmount = $booking->amount - ($booking->service_fee + $booking->stripe_fee);
                    $singleClassPrice = ClassHubHelper::roundCents($bookingAmount / $booking->classes->count());
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
                if ($booking->classes->count() - $requestAndPayoutCount == 1 && $cancellableBookingClass['refund']) {
                    $singleClassAmount = $totalRefundableAmount - $totalRefundedAndPayoutAmount;
                    $amountToRefund += $totalRefundableAmount - $totalRefundedAndPayoutAmount;
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
            
            $bookingCtrlr = new BookingController();
            
            // whether Stripe Fee should be transfer to Tutor Stripe account
            $bookingCtrlr->transferStripeFee($booking, $amountToRefund);
            
            // Refund Booking to User
            $refund = StripeController::refundCharge($chargeTxn, $amountToRefund, $teacher);
            
            $refundTxn = $bookingCtrlr->storeTransaction($booking, $refund);
            
            RefundRequest::where('booking_id', $booking->id)
                ->whereIn('lesson_class_id', Arr::pluck($cancellableBookingClasses, 'id'))
                ->update(['transaction_id' => $refundTxn->id]);
            
            
            if ($booking->amount == ($booking->refunded_amount + $amountToRefund)) {
                $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund,
                    'status' => 'cancelled']);
            } else {
                $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund]);
            }
            
            echo '<p><strong>Results : </strong></p>';
            echo '<p>Booking Date : ' . Carbon::parse($booking->created_at)->format('d-m-Y') . '</p>';
            echo '<p>Cancel Date : ' . Carbon::now()->format('d-m-Y') . '</p>';
            echo '<p>Refund ID : ' . $refund->id . '</p>';
            echo '<p>Refund Amount : ' . $refund->amount . '</p>';
            echo '<p>Class Dates : </p>';
            echo '<p>' . implode('<br>', $successMessages) . '</p>';
            
            echo '<p><strong>Booking Details : </strong></p>';
            echo '<p>Class Name : ' . $lesson->name . '</p>';
            echo '<p>Number of Classes : ' . $lesson->classes->count() . '</p>';
            echo '<p>Student Name: ' . $parents[0]->name . '</p>';
            echo '<p>Booking Code : ' . ClassHubHelper::getbookingCode($booking) . '</p>';
            
            echo '<p><strong>Payment Details : </strong></p>';
            echo '<p>Class Price : ' . ($booking->amount - $booking->service_fee) . '</p>';
            echo '<p>Booking Amount : ' . $booking->amount . '</p>';
            echo '<p>Application Fee : ' . $booking->application_fee . '</p>';
            echo '<p>Service Fee : ' . $booking->service_fee . '</p>';
            echo '<p>Stripe Fee : ' . $booking->stripe_fee . '</p>';
            echo '<p>Charge ID : ' . $charge->id . '</p>';
            echo '<p>Charge Amount : ' . $charge->amount . '</p>';
            
            echo '<p><strong>Displayed to Provider : </strong></p>';
            echo '<p>Provider Earning : ' . $this->getEarningAmount($booking) . '</p>';
            echo '<p>Classhub Earning : ' . $this->getCommissionAmount($booking) . '</p>';
            
        } catch (\Exception $e) {
            dump($e->getTrace());
        }
        
        echo '<p>================== TEST 8 END ==============</p>';
        
    }
    
    public function test9($teacher, $parents, $random = false)
    {
        echo '<p>================== TEST 9 ==============</p>';
        echo '<h3>Test case: Book term/group class. BOOKING OUT OF 14 days.
                Cancel requested after 14 day but before 12 hour</h3>';
        
        try {
            $lesson = $this->createGroupClass($teacher, $random ? rand(2, 10) : 10, $random);
            
            list($booking, $charge) = $this->bookLesson($lesson, $teacher, $parents[1]);
            
            $booking->update(['created_at' => Carbon::now()->subDays(rand(15, 30))->format('Y-m-d H:i:s')]);
            
            $lesson->classes->first()->update([
                'date' => Carbon::now()->addDay()->format('Y-m-d'),
            ]);
            
            $bookingCtrlr = new BookingController();
            
            list($cancellableBookingClasses, $successMessages, $errorMessages)
                = $bookingCtrlr->getCancellableGroupTermClasses($booking);
            
            $requestGroup = uniqid();
            
            // Get the Charge transaction of booking
            $chargeTxn = $booking->transactions->where('amount', $booking->amount)
                ->where('type', 'charge')->where('status', 'succeeded')->first();
            
            foreach ($cancellableBookingClasses as $index => $cancellableBookingClass) {
                // 14 days rule applied
                if ($cancellableBookingClass['14days_rule'] && $cancellableBookingClass['refund']) {
                    $singleClassPrice = ClassHubHelper::roundCents($booking->amount / $booking->classes->count());
                } else if ($cancellableBookingClass['refund']) {
                    $bookingAmount = $booking->amount - ($booking->service_fee + $booking->stripe_fee);
                    $singleClassPrice = ClassHubHelper::roundCents($bookingAmount / $booking->classes->count());
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
                if ($booking->classes->count() - $requestAndPayoutCount == 1 && $cancellableBookingClass['refund']) {
                    $singleClassAmount = $totalRefundableAmount - $totalRefundedAndPayoutAmount;
                    $amountToRefund += $totalRefundableAmount - $totalRefundedAndPayoutAmount;
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
            
            if ($amountToRefund) {
                // whether Stripe Fee should be transfer to Tutor Stripe account
                $bookingCtrlr->transferStripeFee($booking, $amountToRefund);
                
                // Refund Booking to User
                $refund = StripeController::refundCharge($chargeTxn, $amountToRefund, $teacher);
                
                $refundTxn = $bookingCtrlr->storeTransaction($booking, $refund);
                
                RefundRequest::where('booking_id', $booking->id)
                    ->whereIn('lesson_class_id', Arr::pluck($cancellableBookingClasses, 'id'))
                    ->update(['transaction_id' => $refundTxn->id]);
                
                
                if ($booking->amount == ($booking->refunded_amount + $amountToRefund)) {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund,
                        'status' => 'cancelled']);
                } else {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund]);
                }
            }
            
            
            echo '<p><strong>Results : </strong></p>';
            echo '<p>Booking Date : ' . Carbon::parse($booking->created_at)->format('d-m-Y') . '</p>';
            echo '<p>Cancel Date : ' . Carbon::now()->format('d-m-Y') . '</p>';
            echo '<p>Refund ID : ' . $refund->id . '</p>';
            echo '<p>Refund Amount : ' . $refund->amount . '</p>';
            echo '<p>Class Dates : </p>';
            echo '<p>' . implode('<br>', $successMessages) . '</p>';
            
            echo '<p><strong>Booking Details : </strong></p>';
            echo '<p>Class Name : ' . $lesson->name . '</p>';
            echo '<p>Number of Classes : ' . $lesson->classes->count() . '</p>';
            echo '<p>Student Name: ' . $parents[0]->name . '</p>';
            echo '<p>Booking Code : ' . ClassHubHelper::getbookingCode($booking) . '</p>';
            
            echo '<p><strong>Payment Details : </strong></p>';
            echo '<p>Class Price : ' . ($booking->amount - $booking->service_fee) . '</p>';
            echo '<p>Booking Amount : ' . $booking->amount . '</p>';
            echo '<p>Application Fee : ' . $booking->application_fee . '</p>';
            echo '<p>Service Fee : ' . $booking->service_fee . '</p>';
            echo '<p>Stripe Fee : ' . $booking->stripe_fee . '</p>';
            echo '<p>Charge ID : ' . $charge->id . '</p>';
            echo '<p>Charge Amount : ' . $charge->amount . '</p>';
            
            echo '<p><strong>Displayed to Provider : </strong></p>';
            echo '<p>Provider Earning : ' . $this->getEarningAmount($booking) . '</p>';
            echo '<p>Classhub Earning : ' . $this->getCommissionAmount($booking) . '</p>';
            
        } catch (\Exception $e) {
            dump($e->getTrace());
        }
        
        echo '<p>================== TEST 9 END ==============</p>';
        
    }
    
    public function test10($teacher, $parents, $random = false)
    {
        
        echo '<p>================== TEST 10 ==============</p>';
        echo '<h3>Test case: Book group/term class. BOOKING OUT OF 14 days.
                 Cancel requested after 14 day and  before class start</h3>';
        
        try {
            $lesson = $this->createGroupClass($teacher, $random ? rand(2, 10) : 10, $random);
            
            list($booking, $charge) = $this->bookLesson($lesson, $teacher, $parents[1]);
            
            $booking->update(['created_at' => Carbon::now()->subDays(rand(15, 30))->format('Y-m-d H:i:s')]);
            
            $bookingCtrlr = new BookingController();
            
            list($cancellableBookingClasses, $successMessages, $errorMessages)
                = $bookingCtrlr->getCancellableGroupTermClasses($booking);
            
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
            
            if ($amountToRefund) {
                // whether Stripe Fee should be transfer to Tutor Stripe account
                $bookingCtrlr->transferStripeFee($booking, $amountToRefund);
                
                // Refund Booking to User
                $refund = StripeController::refundCharge($chargeTxn, $amountToRefund, $teacher);
                
                $refundTxn = $bookingCtrlr->storeTransaction($booking, $refund);
                
                RefundRequest::where('booking_id', $booking->id)
                    ->whereIn('lesson_class_id', Arr::pluck($cancellableBookingClasses, 'id'))
                    ->update(['transaction_id' => $refundTxn->id]);
                
                
                if ($booking->amount == ($booking->refunded_amount + $amountToRefund)) {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund,
                        'status' => 'cancelled']);
                } else {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund]);
                }
            }
            
            echo '<p><strong>Results : </strong></p>';
            echo '<p>Booking Date : ' . Carbon::parse($booking->created_at)->format('d-m-Y') . '</p>';
            echo '<p>Cancel Date : ' . Carbon::now()->format('d-m-Y') . '</p>';
            echo '<p>Refund ID : ' . $refund->id . '</p>';
            echo '<p>Refund Amount : ' . $refund->amount . '</p>';
            echo '<p>Class Dates : </p>';
            echo '<p>' . implode('<br>', $successMessages) . '</p>';
            
            echo '<p><strong>Booking Details : </strong></p>';
            echo '<p>Class Name : ' . $lesson->name . '</p>';
            echo '<p>Number of Classes : ' . $lesson->classes->count() . '</p>';
            echo '<p>Student Name: ' . $parents[0]->name . '</p>';
            echo '<p>Booking Code : ' . ClassHubHelper::getbookingCode($booking) . '</p>';
            
            echo '<p><strong>Payment Details : </strong></p>';
            echo '<p>Class Price : ' . ($booking->amount - $booking->service_fee) . '</p>';
            echo '<p>Booking Amount : ' . $booking->amount . '</p>';
            echo '<p>Application Fee : ' . $booking->application_fee . '</p>';
            echo '<p>Service Fee : ' . $booking->service_fee . '</p>';
            echo '<p>Stripe Fee : ' . $booking->stripe_fee . '</p>';
            echo '<p>Charge ID : ' . $charge->id . '</p>';
            echo '<p>Charge Amount : ' . $charge->amount . '</p>';
            
            echo '<p><strong>Displayed to Provider : </strong></p>';
            echo '<p>Provider Earning : ' . $this->getEarningAmount($booking) . '</p>';
            echo '<p>Classhub Earning : ' . $this->getCommissionAmount($booking) . '</p>';
            
        } catch (\Exception $e) {
            dump($e->getTrace());
        }
        
        echo '<p>================== TEST 10 END ==============</p>';
        
    }
    
    public function test11($teacher, $parents, $random = false)
    {
        
        echo '<p>================== TEST 11 ==============</p>';
        echo '<h3>Test case: Book group/term class. BOOKING WITHIN 14 days. Cancel requested before class start</h3>';
        
        try {
            $lesson = $this->createGroupClass($teacher, $random ? rand(2, 10) : 10, $random);
            
            list($booking, $charge) = $this->bookLesson($lesson, $teacher, $parents[1]);
            
            $booking->update(['created_at' => Carbon::now()->subDays(rand(1, 14))->format('Y-m-d H:i:s')]);
            
            $bookingCtrlr = new BookingController();
            
            list($cancellableBookingClasses, $successMessages, $errorMessages)
                = $bookingCtrlr->getCancellableGroupTermClasses($booking);
            
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
            
            if ($amountToRefund) {
                // whether Stripe Fee should be transfer to Tutor Stripe account
                $bookingCtrlr->transferStripeFee($booking, $amountToRefund);
                
                // Refund Booking to User
                $refund = StripeController::refundCharge($chargeTxn, $amountToRefund, $teacher);
                
                $refundTxn = $bookingCtrlr->storeTransaction($booking, $refund);
                
                RefundRequest::where('booking_id', $booking->id)
                    ->whereIn('lesson_class_id', Arr::pluck($cancellableBookingClasses, 'id'))
                    ->update(['transaction_id' => $refundTxn->id]);
                
                
                if ($booking->amount == ($booking->refunded_amount + $amountToRefund)) {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund,
                        'status' => 'cancelled']);
                } else {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund]);
                }
            }
            
            echo '<p><strong>Results : </strong></p>';
            echo '<p>Booking Date : ' . Carbon::parse($booking->created_at)->format('d-m-Y') . '</p>';
            echo '<p>Cancel Date : ' . Carbon::now()->format('d-m-Y') . '</p>';
            echo '<p>Refund ID : ' . $refund->id . '</p>';
            echo '<p>Refund Amount : ' . $refund->amount . '</p>';
            echo '<p>Class Dates : </p>';
            echo '<p>' . implode('<br>', $successMessages) . '</p>';
            
            echo '<p><strong>Booking Details : </strong></p>';
            echo '<p>Class Name : ' . $lesson->name . '</p>';
            echo '<p>Number of Classes : ' . $lesson->classes->count() . '</p>';
            echo '<p>Student Name: ' . $parents[0]->name . '</p>';
            echo '<p>Booking Code : ' . ClassHubHelper::getbookingCode($booking) . '</p>';
            
            echo '<p><strong>Payment Details : </strong></p>';
            echo '<p>Class Price : ' . ($booking->amount - $booking->service_fee) . '</p>';
            echo '<p>Booking Amount : ' . $booking->amount . '</p>';
            echo '<p>Application Fee : ' . $booking->application_fee . '</p>';
            echo '<p>Service Fee : ' . $booking->service_fee . '</p>';
            echo '<p>Stripe Fee : ' . $booking->stripe_fee . '</p>';
            echo '<p>Charge ID : ' . $charge->id . '</p>';
            echo '<p>Charge Amount : ' . $charge->amount . '</p>';
            
            echo '<p><strong>Displayed to Provider : </strong></p>';
            echo '<p>Provider Earning : ' . $this->getEarningAmount($booking) . '</p>';
            echo '<p>Classhub Earning : ' . $this->getCommissionAmount($booking) . '</p>';
            
        } catch (\Exception $e) {
            dump($e->getTrace());
        }
        
        echo '<p>================== TEST 11 END ==============</p>';
        
    }
    
    public function test12($teacher, $parents, $random = false)
    {
        
        echo '<p>================== TEST 12 ==============</p>';
        echo '<h3>Test case: Book group/term class. 1 class done, cancel rest</h3>';
        
        try {
            $lesson = $this->createGroupClass($teacher, $random ? rand(2, 10) : 10, $random);
            
            list($booking, $charge) = $this->bookLesson($lesson, $teacher, $parents[1]);
            
            $booking->update(['created_at' => Carbon::now()->subDays(rand(15, 30))->format('Y-m-d H:i:s')]);
            
            $lesson->classes->first()->update([
                'date' => Carbon::now()->subDay()->format('Y-m-d'),
            ]);
            
            $bookingCtrlr = new BookingController();
            
            list($cancellableBookingClasses, $successMessages, $errorMessages)
                = $bookingCtrlr->getCancellableGroupTermClasses($booking);
            
            //dd($cancellableBookingClasses);
            
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
            
            if ($amountToRefund) {
                // whether Stripe Fee should be transfer to Tutor Stripe account
                $bookingCtrlr->transferStripeFee($booking, $amountToRefund);
                
                // Refund Booking to User
                $refund = StripeController::refundCharge($chargeTxn, $amountToRefund, $teacher);
                
                $refundTxn = $bookingCtrlr->storeTransaction($booking, $refund);
                
                RefundRequest::where('booking_id', $booking->id)
                    ->whereIn('lesson_class_id', Arr::pluck($cancellableBookingClasses, 'id'))
                    ->update(['transaction_id' => $refundTxn->id]);
                
                
                if ($booking->amount == ($booking->refunded_amount + $amountToRefund)) {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund,
                        'status' => 'cancelled']);
                } else {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund]);
                }
            }
            
            echo '<p><strong>Results : </strong></p>';
            echo '<p>Booking Date : ' . Carbon::parse($booking->created_at)->format('d-m-Y') . '</p>';
            echo '<p>Cancel Date : ' . Carbon::now()->format('d-m-Y') . '</p>';
            echo '<p>Refund ID : ' . $refund->id . '</p>';
            echo '<p>Refund Amount : ' . $refund->amount . '</p>';
            echo '<p>Class Dates : </p>';
            echo '<p>' . implode('<br>', $successMessages) . '</p>';
            
            echo '<p><strong>Booking Details : </strong></p>';
            echo '<p>Class Name : ' . $lesson->name . '</p>';
            echo '<p>Number of Classes : ' . $lesson->classes->count() . '</p>';
            echo '<p>Student Name: ' . $parents[0]->name . '</p>';
            echo '<p>Booking Code : ' . ClassHubHelper::getbookingCode($booking) . '</p>';
            
            echo '<p><strong>Payment Details : </strong></p>';
            echo '<p>Class Price : ' . ($booking->amount - $booking->service_fee) . '</p>';
            echo '<p>Booking Amount : ' . $booking->amount . '</p>';
            echo '<p>Application Fee : ' . $booking->application_fee . '</p>';
            echo '<p>Service Fee : ' . $booking->service_fee . '</p>';
            echo '<p>Stripe Fee : ' . $booking->stripe_fee . '</p>';
            echo '<p>Charge ID : ' . $charge->id . '</p>';
            echo '<p>Charge Amount : ' . $charge->amount . '</p>';
            
            echo '<p><strong>Displayed to Provider : </strong></p>';
            echo '<p>Provider Earning : ' . $this->getEarningAmount($booking) . '</p>';
            echo '<p>Classhub Earning : ' . $this->getCommissionAmount($booking) . '</p>';
            
            
        } catch (\Exception $e) {
            dump($e->getTrace());
        }
        
        echo '<p>================== TEST 12 END ==============</p>';
        
    }
    
    public function test13($teacher, $parents, $random = false)
    {
        
        echo '<p>================== TEST 13 ==============</p>';
        echo '<h3>Test case: Book group/term class. 2 class done, cancel rest</h3>';
        
        try {
            $lesson = $this->createGroupClass($teacher, $random ? rand(2, 10) : 10, $random);
            
            list($booking, $charge) = $this->bookLesson($lesson, $teacher, $parents[1]);
            
            $booking->update(['created_at' => Carbon::now()->subDays(rand(1, 14))->format('Y-m-d H:i:s')]);
            
            /*$lesson->classes[0]->update([
                'date' => Carbon::now()->subDay()->format('Y-m-d'),
            ]);
            
            $lesson->classes[1]->update([
                'date' => Carbon::now()->subDay()->format('Y-m-d'),
            ]);*/
            
            foreach ($lesson->classes as $class) {
                $class->update([
                    'date' => Carbon::now()->subDay()->format('Y-m-d'),
                ]);
            }
            
            $bookingCtrlr = new BookingController();
            
            list($cancellableBookingClasses, $successMessages, $errorMessages)
                = $bookingCtrlr->getCancellableGroupTermClasses($booking);
            
            $requestGroup = uniqid();
            $partialRefundAmount = 0;
            $refund = null;
            
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
            
            if ($amountToRefund) {
                // whether Stripe Fee should be transfer to Tutor Stripe account
                $bookingCtrlr->transferStripeFee($booking, $amountToRefund);
                
                // Refund Booking to User
                $refund = StripeController::refundCharge($chargeTxn, $amountToRefund, $teacher);
                
                $refundTxn = $bookingCtrlr->storeTransaction($booking, $refund);
                
                RefundRequest::where('booking_id', $booking->id)
                    ->whereIn('lesson_class_id', Arr::pluck($cancellableBookingClasses, 'id'))
                    ->update(['transaction_id' => $refundTxn->id]);
                
                
                if ($booking->amount == ($booking->refunded_amount + $amountToRefund)) {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund,
                        'status' => 'cancelled']);
                } else {
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund]);
                }
            }
            
            echo '<p><strong>Results : </strong></p>';
            echo '<p>Booking Date : ' . Carbon::parse($booking->created_at)->format('d-m-Y') . '</p>';
            echo '<p>Cancel Date : ' . Carbon::now()->format('d-m-Y') . '</p>';
            /* echo '<p>Refund ID : ' . $refund->id . '</p>';
             echo '<p>Refund Amount : ' . $refund->amount . '</p>';*/
            echo '<p>Class Dates : </p>';
            echo '<p>' . implode('<br>', $successMessages) . '</p>';
            
            echo '<p><strong>Booking Details : </strong></p>';
            echo '<p>Class Name : ' . $lesson->name . '</p>';
            echo '<p>Number of Classes : ' . $lesson->classes->count() . '</p>';
            echo '<p>Student Name: ' . $parents[0]->name . '</p>';
            echo '<p>Booking Code : ' . ClassHubHelper::getbookingCode($booking) . '</p>';
            
            echo '<p><strong>Payment Details : </strong></p>';
            echo '<p>Class Price : ' . ($booking->amount - $booking->service_fee) . '</p>';
            echo '<p>Booking Amount : ' . $booking->amount . '</p>';
            echo '<p>Application Fee : ' . $booking->application_fee . '</p>';
            echo '<p>Service Fee : ' . $booking->service_fee . '</p>';
            echo '<p>Stripe Fee : ' . $booking->stripe_fee . '</p>';
            echo '<p>Charge ID : ' . $charge->id . '</p>';
            echo '<p>Charge Amount : ' . $charge->amount . '</p>';
            
            echo '<p><strong>Displayed to Provider : </strong></p>';
            echo '<p>Provider Earning : ' . $this->getEarningAmount($booking) . '</p>';
            echo '<p>Classhub Earning : ' . $this->getCommissionAmount($booking) . '</p>';
            
            
        } catch (\Exception $e) {
            dump($e->getTrace());
        }
        
        echo '<p>================== TEST 13 END ==============</p>';
        
    }
    
    
    public function createStudents($index, $timestamp)
    {
        return User::create([
            'name' => 'Student_' . $index . '_' . $timestamp,
            'email' => 'student_' . $index . '_' . $timestamp . '@test.com',
            'password' => bcrypt('secret'),
        ]);
    }
    
    public function createTeacher($timestamp)
    {
        $user = User::create([
            'name' => 'Teacher_' . $timestamp,
            'email' => 'teacher_' . $timestamp . '@test.com',
            'password' => bcrypt('secret'),
        ]);
        
        $educator = Educator::create([
            'user_id' => $user->id,
            'teaching_types' => ['Teacher' => 'Teacher'],
            'references_approved' => 1,
        ]);
        
        $this->createStripeAccount($user);
        
        return User::findOrFail($user->id);
    }
    
    public function createStripeAccount($user)
    {
        try {
            
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            
            $fp1 = fopen(public_path('classhub-logo.png'), 'r');
            $fp2 = fopen(public_path('classhub-logo.png'), 'r');
            
            $fileFront = File::create([
                'purpose' => 'identity_document',
                'file' => $fp1
            ]);
            
            $fileBack = File::create([
                'purpose' => 'identity_document',
                'file' => $fp2
            ]);
            
            $account = [
                'type' => 'custom',
                'business_type' => 'individual',
                'business_profile' => [
                    'name' => $user->name,
                    'url' => route('page.educator', $user->slug)
                ],
                'default_currency' => 'EUR',
                'country' => 'IE',
                'email' => $user->email,
                'settings' => [
                    'payouts' => [
                        'schedule' => [
                            'interval' => 'manual'
                        ]
                    ]
                ],
                'tos_acceptance' => [
                    'date' => Carbon::now()->getTimestamp(),
                    'ip' => request()->ip(),
                ],
                'individual' => [
                    'address' => [
                        'line1' => 'line1',
                        'line2' => 'line2',
                        'postal_code' => 'code',
                        'city' => 'city',
                        'state' => 'state',
                        'country' => 'IE',
                    ],
                    'dob' => [
                        'day' => 02,
                        'month' => 06,
                        'year' => 1985,
                    ],
                    'email' => $user->email,
                    'first_name' => $user->name,
                    'last_name' => $user->name,
                    'phone' => '+3539876546789',
                    'verification' => [
                        'document' => [
                            'front' => $fileFront,
                            'back' => $fileBack,
                        ]
                    ]
                ]
            ];
            
            $stripeAccount = Account::create($account);
            
            $bankToken = Token::create([
                'bank_account' => [
                    'country' => 'IE',
                    'currency' => 'eur',
                    'account_holder_name' => $user->name,
                    'account_holder_type' => 'individual',
                    'account_number' => 'IE29AIBK93115212345678'
                ]
            ]);
            
            $bankAccount = Account::createExternalAccount($stripeAccount['id'], ['external_account' => $bankToken]);
            
            $user->update([
                'stripe_acct_id' => $stripeAccount['id'],
                'bank_account' => 1
            ]);
            
            echo '<p>Teacher Stripe Account :' . $stripeAccount['id'] . '</p>';
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
    }
    
    public function createSingleClass($teacher, $numClasses, $random = false)
    {
        try {
            $lesson = Lesson::create([
                'user_id' => $teacher->id,
                'category_id' => 40,
                'name' => $teacher->name . ' class_' . Carbon::now()->toDateTimeString(),
                'type' => 'single',
                'price' => $random ? rand(50, 300) : 100,
                'start_date' => Carbon::now(),
                'description' => 'DESC',
                'max_num_bookings' => 1,
                'age_from' => 10,
                'age_to' => '15',
            ]);
            
            for ($i = 0; $i < $numClasses; $i++) {
                LessonClass::create([
                    'lesson_id' => $lesson->id,
                    'date' => Carbon::now(),
                    'day' => Carbon::now()->shortEnglishDayOfWeek,
                    'start_time' => Carbon::now()->format('H:i:s'),
                    'end_time' => Carbon::now()->addHour()->format('H:i:s'),
                ]);
            }
            
            return $lesson;
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
    }
    
    public function createGroupClass($teacher, $numClasses = 10, $random = false)
    {
        try {
            $lesson = Lesson::create([
                'user_id' => $teacher->id,
                'category_id' => 40,
                'name' => $teacher->name . ' class_' . Carbon::now()->toDateTimeString(),
                'type' => 'group',
                'price' => $random ? rand(50, 300) : 100,
                'start_date' => Carbon::now(),
                'description' => 'DESC',
                'max_num_bookings' => 1,
                'age_from' => 10,
                'age_to' => 15,
            ]);
            
            $yesterday = Carbon::now()->subDay();
            
            for ($i = 0; $i < $numClasses; $i++) {
                LessonClass::create([
                    'lesson_id' => $lesson->id,
                    'date' => $yesterday->addDay(),
                    'day' => $yesterday->shortEnglishDayOfWeek,
                    'start_time' => $yesterday->addHour()->format('H:i:s'),
                    'end_time' => $yesterday->addHour()->format('H:i:s'),
                ]);
            }
            
            return $lesson;
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
    }
    
    public function bookLesson($lesson, $teacher, $parent)
    {
        try {
            
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            
            DB::beginTransaction();
            
            $bookingCtrlr = new BookingController();
            
            $classes = $lesson->classes->pluck('id')->toArray();
            
            list($classFee, $serviceFee) = $bookingCtrlr->getBookingAmounts($lesson, $classes);
            
            
            $totalAmount = $classFee + $serviceFee;
            
            list($applicationFee, $stripeFee) = StripeController::getBookingFees($teacher, $classFee, $serviceFee, 'IE');
            
            $paymentMethod = PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'number' => '4242424242424242',
                    'exp_month' => 11,
                    'exp_year' => 2020,
                    'cvc' => '314'
                ]
            ]);
            
            $sharedPaymentMethod = PaymentMethod::create(
                [
                    'payment_method' => $paymentMethod->id,
                ],
                [
                    'stripe_account' => $teacher->stripe_acct_id
                ]);
            
            $intent = PaymentIntent::create(
                [
                    'payment_method_types' => ['card'],
                    'payment_method' => $sharedPaymentMethod->id,
                    'amount' => $totalAmount,
                    'application_fee_amount' => $applicationFee,
                    'currency' => 'eur',
                    'confirmation_method' => 'manual',
                ],
                [
                    'stripe_account' => $teacher->stripe_acct_id
                ]
            );
            
            $intent = PaymentIntent::retrieve(
                [
                    'id' => $intent->id
                ],
                [
                    'stripe_account' => $teacher->stripe_acct_id
                ]
            );
            
            $intent->confirm();
            
            if ($intent->status === 'succeeded') {
                $charges = $intent->charges->data;
                
                $booking = Booking::create([
                    'user_id' => $parent->id,
                    'code' => ClassHubHelper::uniqueCode(),
                    'student_name' => $parent->name,
                    'lesson_id' => $lesson->id,
                    'amount' => $charges[0]['amount'],
                    'application_fee' => $charges[0]['application_fee_amount'],
                    'provider_fee_percent' => $teacher->educator->provider_fee ? $teacher->educator->provider_fee
                        : Setting::get('provider_fee'),
                    'service_fee' => $serviceFee,
                    'customer_fee_percent' => $teacher->educator->customer_fee ? $teacher->educator->customer_fee
                        : Setting::get('customer_fee'),
                    'stripe_fee' => $stripeFee,
                    'status' => 'completed'
                ]);
                
                $bookingCtrlr->addBookingClasses($booking, $lesson, $classes);
                $bookingCtrlr->updateBookingCounter($lesson, $classes);
                $bookingCtrlr->storeTransaction($booking, $charges[0]);
                
                DB::commit();
                
                return [$booking, $charges[0]];
                
            } else {
                dump('Payment Failed');
                dump($intent);
            }
            
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
    }
    
    public function testPayout($booking)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        $bookingClasses = $booking->classes;
        
        
        foreach ($bookingClasses as $bookingClass) {
            
            $classEndAt = Carbon::parse($bookingClass->class->date . ' ' . $bookingClass->class->end_time);
            
            if ($classEndAt->isFuture() || Carbon::now()->diffInHours($classEndAt, false) >= -24)
                continue;
            
            $refundRequest = RefundRequest::where('booking_id', $booking->id)
                ->where('lesson_class_id', $bookingClass->class->id)->first();
            
            if ($refundRequest && ($refundRequest->has_been_payout || $refundRequest->in_progress)) {
                continue;
            }
            
            list($totalPayableAmount, $totalPayoutAmount) = StripeController::getPayableAndPayoutDetails($booking);
            
            $amountPayablePerClass = ClassHubHelper::roundCents(($booking->amount - ($booking->application_fee +
                        $booking->stripe_fee)) / $booking->classes->count());
            
            $unpaidAmount = $totalPayableAmount - $totalPayoutAmount;
            
            $amountPayablePerClass = $amountPayablePerClass > $unpaidAmount ? $unpaidAmount : $amountPayablePerClass;
            
            $payout = null;
            
            $user = $booking->lesson->user;
            
            try {
                $token = Token::create([
                    'card' => [
                        'number' => '4000000000000077',
                        'exp_month' => 7,
                        'exp_year' => 2020,
                        'cvc' => '314'
                    ]
                ]);
                
                $charge = Charge::create([
                    'amount' => 40000,
                    'currency' => 'eur',
                    'source' => $token,
                    'description' => 'Topup'
                ], ['stripe_account' => $user->stripe_acct_id]);
                
                $payout = StripeController::payout($user, $booking, $amountPayablePerClass, $bookingClass->class->id);
                
                DB::beginTransaction();
                
                $transaction = Transaction::create([
                    'booking_id' => $booking->id,
                    'txn_id' => $payout->id,
                    'amount' => $payout->amount,
                    'txn_details' => json_encode($payout),
                    'status' => $payout['status'],
                    'type' => $payout['object']
                ]);
                
                $bookingClass->update([
                    'transaction_id' => $transaction->id,
                    'payout_amount' => $payout->amount
                ]);
                
                return $payout;
                
                DB::commit();
            } catch (\Exception $e) {
                if ($payout) {
                    ErrorLog::create([
                        'user_id' => $user->id,
                        'type' => 'payout',
                        'data' => 'Booking ID: ' . $booking->id .
                            ', Class ID: ' . $bookingClass->lesson_class_id . ' /  Reason : ' . $e->getMessage(),
                        'details' => json_encode($payout),
                        'status' => 'failed'
                    ]);
                    
                    $payout->cancel();
                    
                } else {
                    ErrorLog::create([
                        'user_id' => $user->id,
                        'type' => 'payout',
                        'data' => 'Booking ID: ' . $booking->id .
                            ', Class ID: ' . $bookingClass->lesson_class_id . ' / Reason : ' .
                            $e->getMessage(),
                        'details' => $e->getTraceAsString(),
                        'status' => 'failed'
                    ]);
                    dump('Payout Error: ' . $e->getMessage());
                    
                }
            }
        }
    }
    
    public function getEarningAmount($booking)
    {
        $totalEarningAmount = 0;
        
        if ($booking->status !== 'cancelled') {
            
            $amountPayablePerClass = ($booking->amount - ($booking->application_fee + $booking->stripe_fee))
                / $booking->classes->count();
            
            foreach ($booking->classes as $bookingClass) {
                
                if ($bookingClass->status === 'cancelled')
                    continue;
                
                $refundRequest = RefundRequest::where('booking_id', $booking->id)
                    ->where('lesson_class_id', $bookingClass->class->id)->first();
                
                if ($refundRequest && ($refundRequest->has_been_payout || $refundRequest->in_progress)) {
                    continue;
                }
                
                $totalEarningAmount += $bookingClass->transaction_id && $bookingClass->payout_amount ?
                    $bookingClass->payout_amount : $amountPayablePerClass;
            }
        }
        
        return ClassHubHelper::roundCents($totalEarningAmount);
    }
    
    public function getCommissionAmount($booking)
    {
        $commissionAmount = 0;
        
        if ($booking->status !== 'cancelled') {
            
            $bookingClassCount = 0;
            
            foreach ($booking->classes as $bookingClass) {
                
                if ($bookingClass->status === 'cancelled')
                    continue;
                
                $refundRequest = RefundRequest::where('booking_id', $booking->id)
                    ->where('lesson_class_id', $bookingClass->class->id)->first();
                
                if ($refundRequest && ($refundRequest->has_been_payout || $refundRequest->in_progress)) {
                    continue;
                }
                
                $bookingClassCount++;
            }
            
            $singleClassPrice = ($booking->amount - $booking->service_fee)
                / $booking->classes->count();
            
            $totalClassPrice = ClassHubHelper::roundCents($singleClassPrice * $bookingClassCount);
            
            $tutorFeeAmt = ClassHubHelper::roundCents(($booking->provider_fee_percent / 100) * $totalClassPrice);
            
            $tutorVatAmt = ClassHubHelper::roundCents($tutorFeeAmt * StripeController::VAT_PERCENT);
            
            $commissionAmount += $tutorFeeAmt + $tutorVatAmt; // - $booking->stripe_fee;
        }
        
        return $commissionAmount;
    }
    
    
}
