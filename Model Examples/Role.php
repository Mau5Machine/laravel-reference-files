<?php
//  php artisan make:model Role -m
namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = [
        'title'
    ];

    // SETTING UP MANY TO MANY RELATIONSHIP WITH USERS
    public function users() {
        return $this->belongsToMany('App\User');
    }
}
