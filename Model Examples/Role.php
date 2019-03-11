<?php
// php artisan make:model Role -m
namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    // INVERSE MANY TO MANY RELATIONSHIP
    public function users() {
        return $this->belongsToMany('App\User');
    }
}
