<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EducatorView
 *
 * @property-read \App\User $educator
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorView query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string|null $ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorView whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorView whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EducatorView whereUserId($value)
 */
class EducatorView extends Model
{
    protected $table = 'educator_views';

    protected $guarded = ['id'];

    public function educator()
    {
        return $this->belongsTo(User::class);
    }


}
