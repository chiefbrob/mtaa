<?php

namespace Dabotap;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'title', 'description','image','estate_id','user_id','status'
    ];

    public function messages(){
    	return $this->hasMany('Dabotap\Message');
    }

    public function estate(){
    	return $this->belongsTo('Dabotap\Estate');
    }

    public function user(){
    	return $this->belongsTo('Dabotap\User');
    }

}
