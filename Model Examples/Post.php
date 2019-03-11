<?php
/* /////// HOW TO ADD DATA WITH TINKER /////////
* php artisan tinker
* $post = App\Post::create(['title'=>'Tinker Addition', 'body'=>'This was added with tinker']);
* /////// YOU CAN ALSO INSTANTIATE THE OBJECT IN TINKER AND PLAY WITH THE DATA ////////
* $post = new App\Post
* $post->title = "This is the title that will be added"
* $post->save(); **To save the data to the database
* ///// FINDING DATA WITH TINKER /////////
* $post = App\Post::find(1), $post = App\Post::where('id', 6)->first(), $post = App\Post::whereId(6)->first();
* ////// UPDATE AND DELETE DATA WITH TINKER //////////
* $post = App\Post::find(6) // THEN // $post->title = "Updated title" // THEN // $post->save();
* $post = App\Post::find(6) // THEN // $post->delete()
* // TO VIEW TRASHED DATA // $post->onlyTrashed() // TO DELETE PERMANENTLY // $post->forceDelete();
* /////// FIND RELATIONSHIPS IN TINKER ////////
* $user = App\User::find(1), $user->roles;
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //

    protected $fillable = [
        'title', 'body'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    // POLYMORPHIC RELATIONSHIPS
    public function photos() {
        return $this->morphMany('App\Photo', 'imageable');
    }
    // POLYMORPHIC RELATIONSHIPS MANY TO MANY
    public function tags() {
        return $this->morphToMany('App\Tag', 'taggable');
    }
}
