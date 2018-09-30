<?php

use App\Role;
use Illuminate\Support\Facades\DB;
use App\User;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'HomeController@userLogout')->name('user.logout');

Route::prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
});

Route::get('datepicker', 'TestController@showDatePicker');
Route::group(['middleware' => ['timeout']], function () {
    Route::get('session-expired', 'TestController@sessionExpired');
});
Route::get('ajax-session-expired', 'TestController@ajaxSessionExpired');
Route::post('ajax-session-expired', 'TestController@postSessionExpired')->name('ajax-session-expired');

// Creating dynamic routes
// Instanciate a router class.
$router = app()->make('router');

// For instance this can come from your database.
$paths = ['path/to/route1','path/to/route2','path/to/route3'];

// Then iterate the router "get" method.
foreach ($paths as $path) {
    $router->get($path, 'TestController@index')->name('pilots.index');
}

// optional() helper now supports a callback
Route::get('/optional', function () {
    $a = 1;
    $b = optional($a, function () {
        return 'hi there!';
    });

    echo $b;
});


Route::get('test/{cid}/{qid}', function ($cid, $qid) {
    echo 'CID: '.$cid.' - QID: '.$qid;
})->name('test.route');

Route::get('test/carbon', 'TestController@testCarbon');

Route::get('/multiple-update', function () {
    $records = [
        [
            'id' => 1,
            'name' => 'phich82',
            'email' => 'phich82@gmail.com',
        ],
        [
            'id' => 2,
            'email' => 'jhphich82@gmail.com',
            'name' => 'jhphich82',
        ]
    ];
    dd(User::updateMany($records));
});


Route::get('/grid', function () {
    return view('grid');
});
