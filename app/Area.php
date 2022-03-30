<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Area
 *
 * @property-read \App\User $educator
 * @property-read \App\Lesson $lesson
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Area newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Area onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Area query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Area withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Area withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $state
 * @property string $country
 * @property string|null $latitude
 * @property string|null $longitude
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Area whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Area whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Area whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Area whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Area whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Area whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Area whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Area whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Area whereUpdatedAt($value)
 * @property string $address
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Area whereAddress($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Lesson[] $lessons
 */
class Area extends Model
{
    use SoftDeletes;

    protected $fillable = ['address', 'state', 'country', 'latitude', 'longitude'];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_areas');
    }
}
