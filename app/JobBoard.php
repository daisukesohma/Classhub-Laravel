<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobBoard extends Model
{
    
    protected $fillable = ['educator_id', 'parent_id', 'subject_id', 'group_id', 'message', 'applied', 'detail', 'notified_at'];
    
    public function educator()
    {
        return $this->belongsTo(User::class, 'educator_id');
    }
}
