<?php

namespace App;

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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // SETTING UP A ONE TO ONE RELATIONSHIP FOR ADDRESSES AND USERS
    public function address() {
        return $this->hasOne('App\Address');
    }
    // SETTING UP A ONE TO MANY RELATIONSHIP FOR POSTS AND USERS
    public function posts() {
        return $this->hasMany('App\Post');
    }
    // SETTING UP MANY TO MANY RELATIONSHIP FOR ROLES AND USERS
    public function roles() {
        return $this->belongsToMany('App\Role');
    }
}
