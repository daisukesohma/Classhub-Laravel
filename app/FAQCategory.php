<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FAQCategory
 *
 * @property int $id
 * @property string $name
 * @property string $icon_path
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQCategory whereIconPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQCategory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FAQCategory extends Model
{
    protected $table = 'faq_categories';

    protected $fillable = ['name', 'icon_path', 'type'];
}
