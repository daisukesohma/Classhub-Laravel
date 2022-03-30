<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TopPerformer
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TopPerformer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TopPerformer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TopPerformer query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $educator_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TopPerformer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TopPerformer whereEducatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TopPerformer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TopPerformer whereUpdatedAt($value)
 */
class TopPerformer extends Model
{
    protected $fillable = ['educator_id', 'category_id'];
}
