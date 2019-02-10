<?php

namespace Mtaa;

use Illuminate\Database\Eloquent\Model;

class Terrorist extends Model
{
    protected $fillable = [
        'name', 'image','description','status'
    ];
}
