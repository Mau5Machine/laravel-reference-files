<?php
// php artisan make:model Tag -m
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    // POLYMORPHIC MANY TO MANY RELATIONSHIPS
    public function posts() {
        return $this->morphedByMany('App\Post', 'taggable');
    }
    public function videos() {
        return $this->morphedByMany('App\Video', 'taggable');
    }
}
