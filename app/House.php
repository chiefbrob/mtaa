<?php

namespace Dabotap;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
	protected $fillable = [
        'number', 'image','estate_id','group_id','user_id', 'status',
    ];
    
}
