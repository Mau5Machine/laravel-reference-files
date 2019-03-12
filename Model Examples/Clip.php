<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clip extends Model
{
    //
    protected $fillable = [
        'name'
    ];

    public function tags() {
        return $this->morphToMany('App\Tag', 'taggable');
    }
}
