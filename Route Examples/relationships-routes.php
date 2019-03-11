<?php
use App\Post;
use App\User;
use App\Country;
use App\Photo;
use App\Tag;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// BASIC ROUTES
Route::get('/', function () {
    return view('layouts/app');
});

Route::get('/insert/{name}/{email}/{password}', function($name, $email, $password) {
    $user = new User;
    $user->name = $name;
    $user->email = $email;
    $user->password = $password;
    if ($user->save()) {
        return "New user has been created!";
    } else {
        return "User could not be created";
    }
});

// ONE TO ONE RELATIONSHIP
Route::get('/posts/{id}', function($id) {
    return User::find($id)->post->title;
});

// INVERSE ONE TO ONE
Route::get('/post/{id}/user', function($id) {
    return Post::find($id)->user->name;
});

// ONE TO MANY RELATIONSHIP
Route::get('/posts', function() {
    $user = User::find(1);
    foreach($user->posts as $post) {
        echo $post . "<br/>";
    }
});
// MANY TO MANY RELATIONSHIPS
Route::get('/roles/{id}', function($id) {
    // PULLING THE ROLE FROM THE USER
    $user = User::find($id);
    // OR
    // $user = User::find($id)->roles()->orderBy('id', 'desc')->get();
    foreach($user->roles as $role) {
        echo $role->name;
    }
});
// ACCESSING PIVOT TABLE
Route::get('user/pivot', function() {
    $user = User::find(1);

    foreach($user->roles as $role) {
        echo $role->pivot->created_at;
    }
});
// MANY THROUGH RELATIONSHIP
Route::get('/user/country', function() {

    $country = Country::find(4);
    // GRABBING ALL THE POSTS FROM THE USER THAT IS FROM USA
    foreach($country->posts as $post) {
        echo $post->title;
    }
});
// POLYMORPHIC RELATIONSHIPS
Route::get('/user/photo', function() {
    $user = User::find(1);
    foreach($user->photos as $photo) {
        echo $photo->path;
    }
});
// POLYMORPHIC RELATIONSHIPS PART 2
Route::get('/post/photo', function() {
    $post = Post::find(1);
    foreach($post->photos as $photo) {
        echo $photo->path . "<br/>";
    }
});
// INVERSE POLYMORPHIC RELATIONSHIP **PULLING THE OWNER OF THE PHOTO BY ID
Route::get('photo/{id}/post', function($id) {
    $photo = Photo::findOrFail($id);
    $imageable = $photo->imageable;
    return $imageable;
});
// MANY TO MANY POLYMORPHIC RELATIONSHIPS **PULLING THE TAG NAME FROM THE POST ID
Route::get('posts/tag/find', function() {
    $posts = Post::find(2);
    foreach($posts->tags as $tag) {
        echo $tag->name;
    }
});
// MANY TO MANY POLYMORPHIC INVERSE **PULLING THE POST NAME FROM THE TAG ID
Route::get('/tag/post', function() {
    $tag = Tag::find(2);
    foreach($tag->posts as $post) {
        echo $post->title;
    }
});
