<?php

namespace App;

use App\Helpers\ClassHubHelper;
use App\Http\Controllers\StripeController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Transaction
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $booking_id
 * @property string $txn_id
 * @property int $amount
 * @property string $txn_details
 * @property string $status
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereTxnDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereTxnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereUpdatedAt($value)
 * @property string|null $comment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereComment($value)
 */
class Transaction extends Model
{
    protected $fillable = ['booking_id', 'txn_id', 'amount', 'txn_details', 'status', 'comment', 'type'];
    
    public static function getEducatorTransactions($types = ['charge'])
    {
        $response = [];
        
        $bookingIds = Educator::getAllBookings()->pluck('id');
        
        $transactions = Transaction::whereIn('booking_id', $bookingIds)
            ->where('status', 'succeeded')->get();
        
        foreach ($types as $type) {
            $response[] = $transactions->where('type', $type)->all();
        }
        
        return $response;
    }
    
    public static function getBookingsAmount($bookings, $type, $date)
    {
        $dateFormat = $type == 'year' ? 'Y' : 'Y-m';
        $totalBookingAmount = 0;
        
        foreach ($bookings as $booking) {
            
            if (is_null($date) || (Carbon::parse($booking->created_at)->format($dateFormat) == $date
                    && $booking->status !== 'cancelled')) {
                
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
                
                $totalBookingAmount += $totalClassPrice;
                
            }
        }
        
        return $totalBookingAmount;
    }
    
    public static function getEarningsAmount($bookings, $type, $date)
    {
        $dateFormat = $type == 'year' ? 'Y' : 'Y-m';
        $totalEarningAmount = 0;
        
        foreach ($bookings as $booking) {
            
            if (is_null($date) || (Carbon::parse($booking->created_at)->format($dateFormat) == $date
                    && $booking->status !== 'cancelled')) {
                
                $amountPayablePerClass = ($booking->amount - ($booking->application_fee + $booking->stripe_fee))
                    / $booking->classes->count();
                
                //$stripeFeePerClass = ClassHubHelper::roundCents($booking->stripe_fee / $booking->classes->count());
                
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
                    //- $stripeFeePerClass;
                    
                }
            }
            
        }
        
        return ClassHubHelper::roundCents($totalEarningAmount);
    }
    
    public static function getCommissionAmount($bookings, $type, $date)
    {
        $dateFormat = $type == 'year' ? 'Y' : 'Y-m';
        $commissionAmount = 0;
        
        foreach ($bookings as $booking) {
            
            if (is_null($date) || (Carbon::parse($booking->created_at)->format($dateFormat) == $date
                    && $booking->status !== 'cancelled')) {
                
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
        }
        
        return $commissionAmount;
    }
    
    public static function getActualCommissionAmount($bookings, $type, $date)
    {
        $dateFormat = $type == 'year' ? 'Y' : 'Y-m';
        $commissionAmount = 0;
        
        foreach ($bookings as $booking) {
            
            if (is_null($date) || (Carbon::parse($booking->created_at)->format($dateFormat) == $date
                    && $booking->status !== 'cancelled')) {
                
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
                
                $commissionAmount += $tutorFeeAmt + $tutorVatAmt + $booking->service_fee; // - $booking->stripe_fee;
            }
        }
        
        return $commissionAmount;
    }
    
    
    public static function getStripeFee($bookings, $type, $date)
    {
        $dateFormat = $type == 'year' ? 'Y' : 'Y-m';
        $stripeFee = 0;
        
        foreach ($bookings as $booking) {
            
            if (Carbon::parse($booking->created_at)->format($dateFormat) == $date
                && $booking->status == 'completed') {
                $stripeFee += $booking->stripe_fee;
            }
        }
        
        return $stripeFee;
    }
    
    public static function getServiceCharge($bookings, $type, $date)
    {
        $dateFormat = $type == 'year' ? 'Y' : 'Y-m';
        $serviceCharge = 0;
        
        foreach ($bookings as $booking) {
            
            if (Carbon::parse($booking->created_at)->format($dateFormat) == $date
                && $booking->status == 'completed') {
                $serviceCharge += $booking->service_fee;
            }
        }
        
        return $serviceCharge;
    }
    
}
