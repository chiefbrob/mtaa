<?php

namespace Mtaa;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'title', 'description','image','estate_id','user_id','status'
    ];

    public function messages(){
    	return $this->hasMany('Mtaa\Message');
    }

    public function estate(){
    	return $this->belongsTo('Mtaa\Estate');
    }

    public function user(){
    	return $this->belongsTo('Mtaa\User');
    }

}
