<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\RefundRequest
 *
 * @property int $booking_id
 * @property int $lesson_class_id
 * @property string|null $request_reason
 * @property string|null $decline_reason
 * @property int|null $transaction_id
 * @property int $dispute
 * @property string $status
 * @property string|null $action_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Booking $booking
 * @property-read \App\LessonClass $class
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest whereActionBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest whereDeclineReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest whereDispute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest whereLessonClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest whereRequestReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $group
 * @property int $amount
 * @property-read mixed $has_been_payout
 * @property-read mixed $in_progress
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RefundRequest whereGroup($value)
 */
class RefundRequest extends Model
{
    protected $fillable = ['booking_id', 'lesson_class_id', 'group', 'amount', 'request_reason', 'decline_reason',
        'transaction_id', 'dispute', 'status', 'action_by'];
    
    //protected $appends = ['has_been_payout', 'in_progress'];
    
    const VALIDATION_RULES = [
        'booking_id' => 'required',
        'message' => 'required|max:500',
        'classes' => 'required'
    ];
    
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('booking_id', '=', $this->getAttribute('booking_id'))
            ->where('lesson_class_id', '=', $this->getAttribute('lesson_class_id'));
        return $query;
    }
    
    public function getHasBeenPayoutAttribute()
    {
        return $this->transaction_id && $this->status == 'granted';
    }
    
    public function getInProgressAttribute()
    {
        return $this->status == 'pending' || is_null($this->transaction_id);
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
