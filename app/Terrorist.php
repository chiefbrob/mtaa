<?php

namespace Dabotap;

use Illuminate\Database\Eloquent\Model;

class Terrorist extends Model
{
    protected $fillable = [
        'name', 'image','description','status'
    ];
}
