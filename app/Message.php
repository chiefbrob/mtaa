<?php

namespace Mtaa;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id','group_id', 'contents'
    ];

    public function user(){
    	return $this->belongsTo('Mtaa\User');
    }

    public function group(){
    	return $this->belongsTo('Mtaa\Group');
    }
}
