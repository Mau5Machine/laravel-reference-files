<?php
use App\Listing;
use App\User;
use App\Menu;
use App\Country;
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
        return "User has been inserted!";
    } else {
        return "There was an error!";
    }
});

Route::get('/add_menu_item', function() {
    $menu = new Menu;
    $menu->name = 'Chicken Nuggets';
    $menu->description = 'Flaky and Tender';
    $menu->price = 20.99;
    $menu->category_id = 4;
    $menu->save();
});

Route::get('find_record', function() {
    $user = User::find(1);
    return $user->name;
});

Route::get('/roles/{id}/user', function($id) {

    $user = User::find($id)->roles()->orderBy('name')->get();
    return $user;

    // foreach($user->roles as $role) {
    //     echo $role->name;
    // }
});

Route::get('listings/{id}/user', function($id) {
    $listing = Listing::all();
    return $listing;
});
// Route::get('/user/country', function() {

//     $country = Country::find(1);
    
//     foreach($country->listing as $listing) {
//         echo $listing->name;
//     }
// });