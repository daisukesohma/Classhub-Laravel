<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Card
 *
 * @property int $user_id
 * @property string $card_id
 * @property string $last4
 * @property string $brand
 * @property int $is_default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Card newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Card newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Card query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Card whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Card whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Card whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Card whereLast4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Card whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Card whereUserId($value)
 * @mixin \Eloquent
 * @property string $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Card whereCountry($value)
 */
class Card extends Model
{
    protected $fillable = ['user_id', 'card_id', 'last4', 'brand', 'country', 'is_default'];

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('user_id', '=', $this->getAttribute('user_id'))
            ->where('card_id', '=', $this->getAttribute('card_id'));
        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
