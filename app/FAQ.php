<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FAQ
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ query()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ educator()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ parent()
 * @property int $id
 * @property string $question
 * @property string $answer
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereUpdatedAt($value)
 * @property int $category_id
 * @property-read \App\FAQCategory $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereCategoryId($value)
 */
class FAQ extends Model
{
    protected $table = 'faqs';

    protected $fillable = ['question', 'answer', 'type', 'category_id'];

    protected $with = ['category'];

    const VALIDATION_RULES = [
        'question' => 'required',
        'answer' => 'required',
        'type' => 'required',
        'category_id' => 'required'
    ];

    public function scopeParent()
    {
        return self::where('type', 'parent');
    }

    public function scopeEducator()
    {
        return self::where('type', 'educator');
    }

    public function category()
    {
        return $this->belongsTo(FAQCategory::class, 'category_id');
    }
}
