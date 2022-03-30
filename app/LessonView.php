<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\LessonView
 *
 * @property-read \App\Lesson $lesson
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonView query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $lesson_id
 * @property int|null $user_id
 * @property string|null $ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonView whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonView whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonView whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonView whereUserId($value)
 */
class LessonView extends Model
{
    protected $table = 'lesson_views';

    protected $fillable = ['lesson_id', 'user_id', 'ip'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
