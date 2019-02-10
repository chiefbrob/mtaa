<?php

namespace Mtaa;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    protected $fillable = [
         'title','image','description',
    ];

    public function estates(){
    	return $this->hasMany('Mtaa\Estate');
    }

}
