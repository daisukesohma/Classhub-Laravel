<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Testimonial
 *
 * @property int $id
 * @property string $name
 * @property string $location
 * @property string $content
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Testimonial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Testimonial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Testimonial query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Testimonial whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Testimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Testimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Testimonial whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Testimonial whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Testimonial whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Testimonial whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $educator_image
 * @property string $for
 * @property float $rating
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Testimonial whereEducatorImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Testimonial whereFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Testimonial whereRating($value)
 */
class Testimonial extends Model
{
    protected $fillable = ['educator_image', 'for', 'name', 'content', 'rating'];

    const VALIDATION_RULE = [
        'educator_image' => 'required',
        'for' => 'required',
        'name' => 'required',
        'content' => 'required',
        'rating' => 'required'
    ];
}
