<?php

namespace Dabotap;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username', 'email','phone', 'gender' ,'identification','house_id','role','phone_verified_at', 'status','password'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAnAdmin(){
        if($this->role == "admin")
            return true;
        return false;
    }

    public function hasAHouse(){
        return $this->house_id ? true : false;
    }

    public function house(){
        return $this->hasOne('Dabotap\House');
    }
}
