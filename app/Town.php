<?php

namespace Dabotap;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    protected $fillable = [
         'title','image','description',
    ];

    public function estates(){
    	return $this->hasMany('Dabotap\Estate');
    }

}
