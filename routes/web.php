<?php

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
    return view('home.index');
})->name('home.index');

Route::get('/about', function() {
    return view('other.about');
})->name('other.about');

Route::prefix('admin')->group(function() {
    Route::get('/', [
        'uses' => 'AdminController@getAdminIndex',
        'as' => 'admin.index'
    ]);
    Route::get('climb/{id}', [
        'uses' => 'AdminController@getAdminClimb',
        'as' => 'admin.climb'
    ]);
    Route::get('climb/{id}/edit', [
        'uses' => 'AdminController@getAdminClimbEdit',
        'as' => 'admin.edit'
    ]);
    Route::post('climb/{id}/edit', [
        'uses' => 'AdminController@postAdminClimbUpdate',
        'as' => 'admin.update'
    ]);
    Route::get('climb/{id}/delete', [
        'uses' => 'AdminController@getAdminClimbDelete',
        'as' => 'admin.delete'
    ]);

});


Route::get('/logout', function() {
    Auth::logout();
    return redirect(route('home.index'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'api/v1'], function () {

    Route::resource('climbs', 'ClimbController', [
        'except' => ['edit', 'create']
    ]);

    Route::resource('climbs/registration', 'RegistrationController', [
        'only' => ['store', 'destroy']
    ]);

    Route::post('register', [
        'uses' => 'AuthController@store'
    ]);

    Route::post('user/signin', [
        'uses' => 'AuthController@signin'
    ]);
});


