<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\LessonClass
 *
 * @property-read \App\Lesson $lesson
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\LessonClass onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\LessonClass withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\LessonClass withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property int $lesson_id
 * @property string|null $date
 * @property string $day
 * @property string $start_time
 * @property string $end_time
 * @property int $num_bookings
 * @property int $bookable
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass whereBookable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass whereNumBookings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass whereStartTime($value)
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass whereStatus($value)
 * @property-read mixed $is_refundable
 * @property-read mixed $can_delete
 * @property-read mixed $is_past_class
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonClass whereUpdatedAt($value)
 * @property-read mixed $is_bookable
 * @property-read mixed $is_cancellable
 */
class LessonClass extends Model
{
    use SoftDeletes;
    
    public $timestamps = true;
    
    protected $fillable = ['lesson_id', 'date', 'day', 'start_time', 'end_time', 'meeting_link',
        'video_name', 'video_id', 'video_status', 'num_bookings', 'bookable', 'status'];
    
    //protected $appends = ['is_refundable', 'is_cancellable', 'can_delete', 'is_past_class', 'is_bookable'];
    
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
    
    public function bookings()
    {
        return $this->hasMany(BookingClass::class);
    }
    
    public function getIsRefundableAttribute()
    {
        $classEndtAt = Carbon::parse($this->date . ' ' . $this->end_time);
        
        // Refundable within 24 hours after class
        return $classEndtAt->isPast() && Carbon::now()->diffInHours($classEndtAt) <= 24;
    }
    
    public function getCanDeleteAttribute()
    {
        $classEndtAt = Carbon::parse($this->date . ' ' . $this->end_time);
        
        // Past class or cancelled/completed can be deleted
        if ($classEndtAt->isPast() || in_array($this->status, ['cancelled', 'completed']))
            return true;
        
        return false;
    }
    
    public function getIsCancellableAttribute()
    {
        $classStartAt = Carbon::parse($this->date . ' ' . $this->start_time);
        
        // Class hasn't started or live or pause can be cancelled
        return $classStartAt->isFuture() || in_array($this->status, ['live', 'paused']);
    }
    
    public function getIsPastClassAttribute()
    {
        $classEndtAt = Carbon::parse($this->date . ' ' . $this->end_time);
        
        // Class already ended or cancelled or completed
        return $classEndtAt->isPast() || in_array($this->status, ['cancelled', 'completed']);
    }
    
    public function getIsBookableAttribute()
    {
        $classStartAt = Carbon::parse($this->date . ' ' . $this->start_time);
        
        if ($classStartAt->isFuture() && $this->status == 'live' && $this->bookable) {
            return true;
        }
        
        return false;
    }
    
}
