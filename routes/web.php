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

Route::get('/', [
    'uses' => 'HomeController@index',
    'as' => 'home.index'
]);
Route::get('home/climb/{id}', [
    'uses' => 'HomeController@getClimb',
    'as' => 'home.climb'
]);

Route::get('/about', function() {
    return view('other.about');
})->name('other.about');

Route::group(['prefix' => 'admin'], function() {
    Route::get('/', [
        'uses' => 'AdminController@getAdminIndex',
        'as' => 'admin.index'
    ]);
    Route::get('create', [
        'uses' => 'AdminController@getAdminCreate',
        'as' => 'admin.create',
        ]);
    Route::post('create', [
        'uses' => 'AdminController@postAdminCreate',
        'as' => 'admin.create',
        'middleware' => 'refreshToken'
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
        'as' => 'admin.update',
        'middleware' => 'refreshToken'
        ]);
    Route::get('climb/{id}/delete', [
        'uses' => 'AdminController@getAdminClimbDelete',
        'as' => 'admin.delete',
        'middleware' => 'refreshToken'
    ]);

});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/logout', function() {
    Auth::logout();
    return redirect('/login');
});

Route::post('/logout', function() {
    Auth::logout();
    return redirect('/login');
})->name('logout');


