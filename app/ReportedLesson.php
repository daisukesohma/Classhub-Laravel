<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ReportedLesson
 *
 * @property int $id
 * @property int $lesson_id
 * @property int $reported_by
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Lesson $lesson
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportedLesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportedLesson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportedLesson query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportedLesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportedLesson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportedLesson whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportedLesson whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportedLesson whereReportedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportedLesson whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReportedLesson extends Model
{
    protected $fillable = ['lesson_id', 'reported_by', 'reason'];

    protected $with = ['lesson'];

    public function user()
    {
        return $this->belongsTo(User::class, 'reported_by')->withTrashed();
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class)->withTrashed();
    }
}
