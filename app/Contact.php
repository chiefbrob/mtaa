<?php

namespace Mtaa;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'names','email', 'message','resolved_by'
    ];
}
