<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Blog
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int|null $featured_image
 * @property string|null $metadata
 * @property \Illuminate\Support\Carbon $published_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Image|null $image
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereFeaturedImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Post withoutTrashed()
 * @mixin \Eloquent
 * @property int $category_id
 * @property string $slug
 * @property-read \App\Category $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereSlug($value)
 */
class Post extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = ['category_id', 'title', 'slug', 'content',
        'featured_image', 'metadata', 'published_at'];

    protected $with = ['image'];

    const VALIDATION_RULES = [
        'title' => 'required',
        'content' => 'required',
        'category_id' => 'required'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title'],
                'separator' => '-'
            ]
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = $value ? Carbon::parse($value)->format('Y-m-d H:i:s')
            : $this->created_at;
    }

    public function setMetadataAttribute($value)
    {
        $this->attributes['metadata'] = serialize($value);
    }

    public function getMetadataAttribute($value)
    {
        return unserialize($value);
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'featured_image');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
