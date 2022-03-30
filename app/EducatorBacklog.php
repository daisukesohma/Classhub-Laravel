<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EducatorBacklog
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorBacklog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorBacklog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorBacklog query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $educator_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorBacklog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorBacklog whereEducatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorBacklog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorBacklog whereUpdatedAt($value)
 */
class EducatorBacklog extends Model
{
    protected $fillable = ['educator_id', 'category_id'];
}
