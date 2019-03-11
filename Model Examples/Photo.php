<?php
// php artisan make:model Photo -m
namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //

    // PLOYMORPHIC RELATIONSHIPS
    public function imageable() {
        return $this->morphTo();
    }
}
