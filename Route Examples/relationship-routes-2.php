<?php
use App\User;
use App\Address;
use App\Post;
use App\Role;
use App\Staff;
use App\Product;
use App\Photo;
use App\Video;
use App\Clip;
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
///////////// MANY TO MANY CRUD OPERATIONS ///////////////////
// CREATING A ROLE AND ASSIGNING USER TO IT
// CREATES A RECORD IN THE ROLE_USER TABLE FOR THE USER THAT HAS THE SPECIFIC ROLE
Route::get('/create_role', function() {
    $user = User::find(1);
    $role = new Role(['title'=>'Admin']);
    $user->roles()->save($role);
});
// READING THE ROLE OF A USER
Route::get('/read_roles', function() {
    $user = User::findOrFail(1);
    // dd($user->roles);
    foreach($user->roles as $role) {
        echo $role->title;
    }
});
// UPDATING DATA
// UPDATING ROLE INFO BASED ON USER ID
Route::get('/update_role', function() {
    $user = User::findOrFail(1);
    if ($user->has('roles')) { // has method can be used to find relationships
        foreach($user->roles as $role) {
            if ($role->title === 'Admin') {
                $role->title = 'Administrator';
                $role->save();
            }
        }
    }
});
// DELETING DATA
Route::get('/delete_role', function() {
    $user = User::findOrFail(2);
    foreach($user->roles as $role) {
        $role->whereId(2)->delete();
    }
});
// ATTACHING A ROLE TO A USER WITH ATTACH() METHOD
// THIS WILL CREATE A NEW RECORD IF THE USER ROLE IS ALREADY ASSIGNED
Route::get('/attach', function() {
    $user = User::findOrFail(1);
    $user->roles()->attach(3);
});
// DETACHING A ROLE FROM A USER
Route::get('/detach', function() {
    $user = User::findOrFail(1);
    $user->roles()->detach(3);
});
// SYNCING
// THIS SYNCS A ROLE TO A USER AND DELETES THE OLD ROLES ASSIGNED TO THE USER
Route::get('/sync_roles', function() {
    $user = User::findOrFail(1);
    $user->roles()->sync([6, 4]);
});
///////////// POLYMORPHIC CRUD OPERATIONS ///////////////////
// CREATING DATA
// THIS ROUTE CREATES A PHOTO FOR A STAFF MEMBER
Route::get('create_morph', function() {
    $staff = Staff::find(1);
    $staff->photos()->create(['path'=>'christian.jpg']);
});
// READING DATA
// GRABBING THE PHOTO PATH FROM THE STAFF MEMBER WITH ID OF 1
Route::get('/read_morph', function() {
    $staff = Staff::findOrFail(1);
    foreach($staff->photos as $photo) {
        echo $photo->path;
    }
});
// UPDATING DATA
// UPDATING PHOTO PATH FROM STAFF MEMBER LOOKUP
Route::get('/update_morph', function() {
    $staff = Staff::findOrFail(1);
    $photo = $staff->photos()->whereId(1)->first();
    $photo->path = 'Brandi.png';
    $photo->save();
});
// DELETING DATA
// DELETING ALL THE PHOTOS WITH STAFF ID 1
Route::get('/delete_morph', function() {
    $staff = Staff::findOrFail(1);
    $staff->photos()->delete();
});
// ASSIGNING
// ASSIGNING A STAFF MEMBER TO A PHOTO
Route::get('/assign', function() {
    $staff = Staff::findOrFail(1);
    $photo = Photo::findOrFail(3);
    $staff->photos()->save($photo);
});
// UNASSIGNING
Route::get('/un-assign', function() {
    $staff = Staff::findOrFail(1);
    $staff->photos()->whereId(2)->update(['imageable_id'=>0, 'imageable_type'=>'']);
});
///////////// POLYMORPHIC MANY TO MANY CRUD OPERATIONS ///////////////////
// CREATING DATA
// CREATING A CLIP AND A VIDEO AND ASSIGNING TAGS TO THEM IN ONE ROUTE!
Route::get('/create_clip', function() {
    $clip = Clip::create(['name'=>'first clip']);
    $tag1 = Tag::find(1);
    $clip->tags()->save($tag1);

    $video = Video::create(['path'=>'unboxing.mov']);
    $tag2 = Tag::find(2);
    $video->tags()->save($tag2);
});
// READING DATA
// READING TAG FROM A SPECIFIC CLIP
Route::get('/read_clips', function() {
    $clip = Clip::findOrFail(1);
    foreach($clip->tags as $tag) {
        echo $tag->name;
    }
});
// UPDATING DATA
// UPDATING TAGS WITH FROM THE CLIP ID
Route::get('/update_clips', function() {
    $clip = Clip::findOrFail(1);
    foreach($clip->tags as $tag) {
        $tag->whereName('PHP')->update(['name'=>'Christian Masterclass']);
    }
});
// UPDATING DATA
// OR UPDATING TAGGABLE ID ASSIGNING A NEW TAG ID TO A CLIP //////
Route::get('/update_clips2', function() {
    $clip = Clip::findOrFail(1);
    $tag = Tag::find(2);
    $clip->tags()->save($tag);
    ///////// THIS DOES THE SAME AS THE SAVE METHOD RIGHT ABOVE //////
    // $clip->tags()->attach(3);
});
// UPDATING DATA
////// SYNCING TAGS ///////
Route::get('/sync_clips', function() {
    $clip = Clip::findOrFail(1);
    $clip->tags()->sync([2]);
});
// DELETING DATA
// DELETING TAGS THROUGH THE CLIP TABLE RELATIONSHIP
Route::get('delete_clips', function() {
    $clip = Clip::findOrFail(2);
    foreach($clip->tags as $tag) {
        $tag->whereId(3)->delete();
    }
});
