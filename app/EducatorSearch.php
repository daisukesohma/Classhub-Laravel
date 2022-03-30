<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EducatorSearch
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorSearch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorSearch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorSearch query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $educator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorSearch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorSearch whereEducatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorSearch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorSearch whereUpdatedAt($value)
 */
class EducatorSearch extends Model
{
    protected $fillable = ['educator_id'];
}
