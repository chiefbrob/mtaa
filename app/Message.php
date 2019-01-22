<?php

namespace Dabotap;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id','group_id', 'contents'
    ];

    public function user(){
    	return $this->belongsTo('Dabotap\User');
    }

    public function group(){
    	return $this->belongsTo('Dabotap\Group');
    }
}
