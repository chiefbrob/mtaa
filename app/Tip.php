<?php

namespace Dabotap;

use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    protected $fillable = [
        'cat_id','description','src','status'
    ];

    public function cat(){
    	return $this->belongsTo('Dabotap\Cat');
    }
}
