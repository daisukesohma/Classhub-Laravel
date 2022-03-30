<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Helpers\ClassHubHelper;
use App\Jobs\SendEmailJob;
use App\Mail\RefundGrantAdminToParent;
use App\Mail\RefundGrantEducatorToParent;
use App\Mail\RefundRejectOr72hrToParent;
use App\Message;
use App\RefundRequest;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class RefundRequestController extends Controller
{
    
    public function acceptByEducator(Request $request)
    {
        try {
            $booking = Booking::findOrFail($request->booking_id);
            $message = Message::findOrFail($request->message_id);
            $classes = strpos($request->class_ids, ',') ? explode(',', $request->class_ids)
                : [$request->class_ids];
            
            $amountToRefund = 0;
            
            $refundRequests = collect([]);
            
            // Get the Charge transaction of booking
            $chargeTxn = $booking->transactions->where('amount', $booking->amount)
                ->where('type', 'charge')->where('status', 'succeeded')->first();
            
            foreach ($classes as $classId) {
                $refundRequest = RefundRequest::where('booking_id', $booking->id)
                    ->where('lesson_class_id', $classId)->firstOrFail();
                
                if ($refundRequest->transaction_id && $refundRequest->status == 'granted')
                    continue;
                
                $refundRequests->add($refundRequest);
                $amountToRefund += $refundRequest->amount;
            }
            
            if ($amountToRefund == 0) {
                return response()->json([
                    'status' => true,
                    'messages' => [Lang::get('messages.refund.accept.exist')],
                ]);
            }
            
            DB::beginTransaction();
            
            $refund = StripeController::refundCharge($booking, $chargeTxn, $amountToRefund, $booking->lesson->user);
            
            $refundTxn = Transaction::create([
                'user_id' => Auth::user()->user_id,
                'booking_id' => $booking ? $booking->id : null,
                'txn_id' => $refund->id,
                'amount' => $refund->amount,
                'txn_details' => json_encode($refund),
                'status' => $refund['status'] ? $refund['status'] : 'succeeded',
                'type' => $refund['object']
            ]);
            
            foreach ($refundRequests as $refundRequest) {
                $refundRequest->update([
                    'transaction_id' => $refundTxn->id,
                    'dispute' => 0,
                    'status' => 'granted',
                    'action_by' => 'tutor',
                ]);
                
                $educator = User::findOrFail($booking->lesson->user_id);
                $parent = User::findOrFail($booking->user_id);
                
                $job = new SendEmailJob($parent->email,
                    new RefundGrantEducatorToParent($parent, $educator, $booking,
                        [$classId], $refund->amount, $parent->email));
                
                $this->dispatch($job);
            }
            
            $booking->update(['refunded_amount' => $booking->refunded_amount + $amountToRefund]);
            
            $message->update(['status' => 'accept']);
            
            $messageController = new MessageController();
            $messageRequest = new Request();
            $messageRequest->setMethod('POST');
            
            $messageRequest->request->replace([
                '_token' => csrf_token(),
                'lesson_id' => $booking->lesson->id,
                'recipient_id' => $booking->user_id,
                'text' => 'Booking Code: ' . ClassHubHelper::getbookingCode($booking) . '<br>' . Auth::user()->name . ' 
                     has accepted the refund request.',
                'status' => 'accept-message'
            ]);
            
            $response = json_decode($messageController->store($messageRequest, false)->getContent());
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.icon.ok'), Lang::get('messages.refund.accept')],
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
    
    
    public function acceptByAdmin(Request $request)
    {
        try {
            $booking = Booking::findOrFail($request->booking_id);
            $classId = $request->class_id;
            
            $transactions = $booking->transactions;
            
            // Get the Charge transaction of booking
            $chargeTxn = $transactions->where('amount', $booking->amount)
                ->where('type', 'charge')->where('status', 'succeeded')->first();
            
            $refundRequest = RefundRequest::where('booking_id', $booking->id)
                ->where('lesson_class_id', $classId)->firstOrFail();
            
            if ($refundRequest->transaction_id && $refundRequest->status == 'granted')
                return response()->json([
                    'status' => true,
                    'messages' => [Lang::get('messages.refund.grant.admin')],
                ]);
            
            DB::beginTransaction();
            
            $refund = StripeController::refundCharge($booking, $chargeTxn, $refundRequest->amount, $booking->lesson->user);
            $refundTxn = Transaction::create([
                'user_id' => Auth::user()->user_id,
                'booking_id' => $booking ? $booking->id : null,
                'txn_id' => $refund->id,
                'amount' => $refund->amount,
                'txn_details' => json_encode($refund),
                'status' => $refund['status'] ? $refund['status'] : 'succeeded',
                'type' => $refund['object']
            ]);
            
            $refundRequest->update([
                'transaction_id' => $refundTxn->id,
                'dispute' => 0,
                'status' => 'granted',
                'action_by' => 'admin',
            ]);
            
            $booking->update(['refunded_amount' => $booking->refunded_amount + $refund->amount]);
            
            $educator = User::findOrFail($booking->lesson->user_id);
            $parent = User::findOrFail($booking->user_id);
            
            $job = new SendEmailJob($parent->email,
                new RefundGrantAdminToParent($parent, $educator, $booking,
                    [$classId], $refund->amount, $parent->email));
            
            $this->dispatch($job);
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.refund.grant.admin')],
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
    
    public function rejectByEducator(Request $request)
    {
        try {
            $booking = Booking::findOrFail($request->booking_id);
            $message = Message::findOrFail($request->message_id);
            $classes = strpos($request->class_ids, ',') ? explode(',', $request->class_ids)
                : [$request->class_ids];
            
            DB::beginTransaction();
            
            foreach ($classes as $classId) {
                $refundRequest = RefundRequest::where('booking_id', $booking->id)
                    ->where('lesson_class_id', $classId)->firstOrFail();
                
                $refundRequest->update([
                    'decline_reason' => $request->reason,
                    'dispute' => 1,
                    'action_by' => 'tutor'
                ]);
                
                $educator = User::findOrFail($booking->lesson->user_id);
                $parent = User::findOrFail($booking->user_id);
                $admin = User::findOrFail(1);
                
                $job1 = new SendEmailJob($parent->email,
                    new RefundRejectOr72hrToParent($parent->name, $parent, $educator, $booking,
                        [$classId], $refundRequest->amount, $parent->email));
                
                $job2 = new SendEmailJob($educator->email,
                    new RefundRejectOr72hrToParent($educator->name, $parent, $educator, $booking,
                        [$classId], $refundRequest->amount, $educator->email));
                
                $job3 = new SendEmailJob($admin->email,
                    new RefundRejectOr72hrToParent($admin->name, $parent, $educator, $booking,
                        [$classId], $refundRequest->amount, $admin->email));
                
                $this->dispatch($job1);
                $this->dispatch($job2);
                $this->dispatch($job3);
            }
            
            $message->update(['status' => 'reject']);
            
            $messageController = new MessageController();
            $messageRequest = new Request();
            $messageRequest->setMethod('POST');
            
            $messageRequest->request->replace([
                '_token' => csrf_token(),
                'lesson_id' => $booking->lesson->id,
                'recipient_id' => $booking->user_id,
                'text' => 'Booking Code: ' . ClassHubHelper::getbookingCode($booking) . '<br>' .
                    Lang::get('messages.refund.reject', ['name' => Auth::user()->name]),
                'status' => 'reject-message'
            ]);
            
            $response = json_decode($messageController->store($messageRequest, false)->getContent());
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.refund.reject.tutor')],
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
    
    public function rejectByAdmin(Request $request)
    {
        try {
            $booking = Booking::findOrFail($request->booking_id);
            $classId = $request->class_id;
            
            DB::beginTransaction();
            
            $refundRequest = RefundRequest::where('booking_id', $booking->id)
                ->where('lesson_class_id', $classId)->firstOrFail();
            
            $refundRequest->update([
                'dispute' => 0,
                'status' => 'declined',
                'action_by' => 'admin'
            ]);
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.refund.decline.admin')],
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
    
    public static function processRefundRequests()
    {
        try {
            $refundRequests = RefundRequest::where('status', 'pending')->get();
            
            foreach ($refundRequests as $refundRequest) {
                $requestDate = Carbon::parse($refundRequest->created_at);
                $lastUpdateDate = Carbon::parse($refundRequest->updated_at);
                
                if ($refundRequest->dispute && $refundRequest->status == 'pending'
                    && Carbon::now()->diffInDays($lastUpdateDate, false) <= -7) {
                    
                    $booking = Booking::findOrFail($refundRequest->booking_id);
                    $classId = $refundRequest->lesson_class_id;
                    
                    $transactions = $booking->transactions;
                    
                    // Get the Charge transaction of booking
                    $chargeTxn = $transactions->where('amount', $booking->amount)
                        ->where('type', 'charge')->where('status', 'succeeded')->first();
                    
                    DB::beginTransaction();
                    
                    $refund = StripeController::refundCharge($booking, $chargeTxn, $refundRequest->amount, $booking->lesson->user);
                    $refundTxn = Transaction::create([
                        'user_id' => Auth::user()->user_id,
                        'booking_id' => $booking ? $booking->id : null,
                        'txn_id' => $refund->id,
                        'amount' => $refund->amount,
                        'txn_details' => json_encode($refund),
                        'status' => $refund['status'] ? $refund['status'] : 'succeeded',
                        'type' => $refund['object']
                    ]);
                    
                    $refundRequest->update([
                        'transaction_id' => $refundTxn->id,
                        'dispute' => 0,
                        'status' => 'granted',
                        'action_by' => 'system',
                    ]);
                    
                    $booking->update(['refunded_amount' => $booking->refunded_amount + $refund->amount]);
                    
                    $educator = User::findOrFail($booking->lesson->user_id);
                    $parent = User::findOrFail($booking->user_id);
                    
                    $job = new SendEmailJob($parent->email,
                        new RefundGrantAdminToParent($parent, $educator, $booking,
                            [$classId], $refund->amount, $parent->email));
                    
                    dispatch($job);
                    
                    DB::commit();
                }
                
                if (!$refundRequest->dispute && $refundRequest->status == 'pending'
                    && Carbon::now()->diffInHours($requestDate, false) <= -72) {
                    
                    dump('3 days');
                    
                    $refundRequest->update(['dispute' => 1]);
                    
                    $booking = Booking::findOrFail($refundRequest->booking_id);
                    
                    $educator = User::findOrFail($booking->lesson->user_id);
                    $parent = User::findOrFail($booking->user_id);
                    $admin = User::findOrFail(1);
                    
                    $job1 = new SendEmailJob($parent->email,
                        new RefundRejectOr72hrToParent($parent->name, $parent, $educator, $booking,
                            [$refundRequest->lesson_class_id], $refundRequest->amount, $parent->email));
                    
                    $job2 = new SendEmailJob($educator->email,
                        new RefundRejectOr72hrToParent($educator->name, $parent, $educator, $booking,
                            [$refundRequest->lesson_class_id], $refundRequest->amount, $educator->email));
                    
                    $job3 = new SendEmailJob($admin->email,
                        new RefundRejectOr72hrToParent($admin->name, $parent, $educator, $booking,
                            [$refundRequest->lesson_class_id], $refundRequest->amount, $admin->email));
                    
                    dispatch($job1);
                    dispatch($job2);
                    dispatch($job3);
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
    
}
