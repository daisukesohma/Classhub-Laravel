<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PasswordReset
 *
 * @property-read mixed $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PasswordReset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PasswordReset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PasswordReset query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property int $completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PasswordReset whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PasswordReset whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PasswordReset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PasswordReset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PasswordReset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PasswordReset whereUserId($value)
 */
class PasswordReset extends Model
{
    protected $fillable = ['user_id', 'code', 'completed'];

    //protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return route('password.reset', [base64_encode($this->user_id), base64_encode($this->code)]);
    }
}
