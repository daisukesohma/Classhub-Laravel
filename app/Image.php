<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Image
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Image onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Image withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Image withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property string $path
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereUpdatedAt($value)
 * @property string|null $thumbnail_path
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereThumbnailPath($value)
 */
class Image extends Model
{

    protected $fillable = ['title', 'path', 'thumbnail_path', 'description'];

}
