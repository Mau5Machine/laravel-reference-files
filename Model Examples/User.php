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
    // ONE TO ONE RELATIONSHIP
    public function post() {
        return $this->hasOne('App\Post');
    }
    // ONE TO MANY RELATIONSHIP
    public function posts() {
        return $this->hasMany('App\Post');
    }
    // MANY TO MANY RELATIONSHIP
    public function roles() {
        // LET THE MODEL KNOW WITH WITHPIVOT METHOD WHAT COLUMN TO TAKE
        return $this->belongsToMany('App\Role')->withPivot('created_at');
    }
    // POLYMORPHIC RELATIONSHIPS
    public function photos() {
        return $this->morphMany('App\Photo', 'imageable');
    }

}
