<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreeVideoCall extends Model
{
    protected $fillable = ['educator_id', 'parent_id', 'call_time', 'meeting_link', 
        'meeting_start', 'complete', 'reminder_sent'];
    
    const VALIDATION_RULES = [
        'educator_id' => 'required|numeric',
        'parent_id' => 'required|numeric',
        'call_time' => 'required'
    ];
    
    protected $dates = ['call_time'];
}
