<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ErrorLog
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $type
 * @property string $data
 * @property string|null $details
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereUserId($value)
 * @mixin \Eloquent
 */
class ErrorLog extends Model
{
    protected $fillable = ['user_id', 'type', 'data', 'details', 'status'];

}

