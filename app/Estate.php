<?php

namespace Mtaa;

use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $fillable = [
        'title', 'description','image','town_id','user_id','status'
    ];

    public function groups(){
    	return $this->hasMany('Mtaa\Group');
    }

    public function user(){
    	return $this->belongsTo('Mtaa\User');
    }

    public function town(){
    	return $this->belongsTo('Mtaa\Town');
    }

    public function houses(){
        return $this->hasMany('Mtaa\House');
    }
    
}
