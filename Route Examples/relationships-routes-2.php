<?php
use App\User;
use App\Address;
use App\Post;

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

Route::get('/', function () {
    return view('welcome');
});
///////////// ONE TO ONE CRUD OPERATIONS //////////////////////
// CREATING AN ADDRESS FOR A USER WITH ONE TO ONE RELATIONSHIP
Route::get('/insert', function() {
    $user = User::findOrFail(1);
    $address = new Address(['name'=>'9500 Sw 3rd Street, Boca Raton, FL, 33428']);
    $user->address()->save($address);
});
// READING DATA
Route::get('/read', function() {
    $user = User::findOrFail(1);
    return $user->address->name;
});
// UPDATING AN ADDRESS
Route::get('/update', function() {
    $address = Address::whereUserId(1)->first();
    $address->name = "9454 SW 9th Street, Boca Raton, FL 33482";
    if ($address->save()) {
        echo "Field has been updated";
    } else {
        echo "Something went wrong";
    }
});
// DELETING DATA
Route::get('/delete', function() {
    $user = User::findOrFail(1);
    if ($user->address()->delete()) {
        echo "Address has been deleted";
    } else {
        echo "No address could be found!";
    }
});
///////////// ONE TO MANY CRUD OPERATIONS ///////////////////
// CREATING A POST WITH ONE TO MANY RELATIONSHIP
Route::get('/create_post', function() {
    $user = User::findOrFail(1);
    $post = new Post(['title'=>'PHP Laravel For Beginners 2', 'body'=>'This is the beginner course in Laravel Learning']);
    if ($user->posts()->save($post)) {
        echo "Record has been created!";
    } else {
        echo "Something went wrong!";
    }
});
// READING DATA
Route::get('/read_post', function() {
    $user = User::findOrFail(1);
    // dd($user->posts); // dd() is the die dump function, can show object or collection item
    foreach($user->posts as $post) {
        echo $post->title . "<br/>";
    }
});
// UPDATING DATA
Route::get('/update_post', function() {
    $user = User::findOrFail(1);
    $user->posts()->whereId(1)->update(['title'=>'Laravel is amazing', 'body'=>'This is so cool!']);
});
// DELETING DATA
Route::get('/delete_post', function() {
    $user = User::findOrFail(1);
    if ($user->posts()->delete()) {
        echo "Record has been deleted";
    } else {
        echo "There was no record to delete!";
    }
});
