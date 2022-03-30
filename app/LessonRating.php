<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ClassRating
 *
 * @property int $educator_id
 * @property int $parent_id
 * @property float $score
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonRating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonRating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonRating query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonRating whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonRating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonRating whereEducatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonRating whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonRating whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonRating whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $lesson_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonRating whereLessonId($value)
 * @property string|null $comment
 * @property-read \App\User $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LessonRating whereComment($value)
 */
class LessonRating extends Model
{
    protected $fillable = ['educator_id', 'parent_id', 'lesson_id', 'score', 'comment'];

    public $timestamps = true;

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}
