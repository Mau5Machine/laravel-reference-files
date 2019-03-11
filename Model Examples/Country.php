<?php
// $ php artisan make:model Country -m
namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    // HAS MANY THROUGH RELATIONSHIP
    public function posts() {
        // LARAVEL IS AUTOMATICALLY LOOKING FOR COUNTRY ID
        return $this->hasManyThrough('App\Post', 'App\User');
    }
}
