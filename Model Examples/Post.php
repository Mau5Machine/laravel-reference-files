<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    // HANDLING MASS ASSIGNMENT, GIVING PERMISSION TO CREATE DATA INSIDE APPLICATION
    protected $fillable = [
        'user_id',
        'title',
        'body'
    ];
}
