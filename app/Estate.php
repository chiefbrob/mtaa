<?php

namespace Dabotap;

use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $fillable = [
        'title', 'description','image','town_id','user_id','status'
    ];

    public function groups(){
    	return $this->hasMany('Dabotap\Group');
    }

    public function user(){
    	return $this->belongsTo('Dabotap\User');
    }

    public function town(){
    	return $this->belongsTo('Dabotap\Town');
    }

    public function houses(){
        return $this->hasMany('Dabotap\House');
    }
    
}
