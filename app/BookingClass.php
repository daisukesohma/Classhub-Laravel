<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\BookingClass
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\BookingClass onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\BookingClass withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\BookingClass withoutTrashed()
 * @mixin \Eloquent
 * @property int $booking_id
 * @property int $lesson_class_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass whereLessonClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass whereUpdatedAt($value)
 * @property int $refund_request
 * @property string|null $refund_requested_at
 * @property int|null $refunded_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass whereRefundRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass whereRefundRequestedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass whereRefundedBy($value)
 * @property string|null $refund_request_reason
 * @property string|null $refund_refuse_reason
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass whereRefundRefuseReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass whereRefundRequestReason($value)
 * @property-read \App\Booking $booking
 * @property-read \App\LessonClass $class
 * @property string|null $action_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass whereActionBy($value)
 * @property int|null $transaction_id
 * @property int $payout_amount
 * @property-read mixed $is_past_booking
 * @property-read mixed $is_refundable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass wherePayoutAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookingClass whereTransactionId($value)
 */
class BookingClass extends Model
{
    protected $fillable = ['booking_id', 'lesson_class_id', 'status', 'action_by', 'transaction_id', 'payout_amount',
        'reminder_sent'];
    
    protected $with = ['class'];
    
    //protected $appends = ['is_refundable', 'is_past_booking', 'has_been_payout'];
    
    public $incrementing = false;
    
    public $timestamps = false;
    
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('booking_id', '=', $this->getAttribute('booking_id'))
            ->where('lesson_class_id', '=', $this->getAttribute('lesson_class_id'));
        return $query;
    }
    
    public function getIsRefundableAttribute()
    {
        // Cancelled or payout
        $cancelOrPayout = $this->status == 'cancelled' || ($this->transaction_id && $this->payout_amount);
        
        $refundRequest = RefundRequest::where('booking_id', $this->booking->id)
            ->where('lesson_class_id', $this->lesson_class_id)->first() ? true : false;
        
        return !$cancelOrPayout && !$refundRequest;
    }
    
    public function getIsPastBookingAttribute()
    {
        $cancelOrPayout = $this->status == 'cancelled' || ($this->transaction_id && $this->payout_amount);
        
        $classDate = Carbon::parse($this->class->date . ' ' . $this->class->end_time);
        
        $pastClass = $classDate->isPast();
        
        return $cancelOrPayout || $pastClass;
        
    }
    
    public function getHasBeenPayoutAttribute()
    {
        return $this->transaction_id && $this->payout_amount;
    }
    
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    
    public function class()
    {
        return $this->belongsTo(LessonClass::class, 'lesson_class_id')
            ->withTrashed();
    }
    
    
}
