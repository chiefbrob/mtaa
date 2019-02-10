<?php

namespace Mtaa;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    protected $fillable = [
        'title','description'
    ];

    public function tips(){
    	return $this->hasMany('Mtaa\Tip');
    }
}
