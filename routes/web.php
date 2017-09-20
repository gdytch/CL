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

Route::get('/', 'HomeController@welcome')->name('welcome');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Admin
Route::get('/admin/login', 'AdminsController@showLoginForm')->name('admin.login.form');
Route::post('/admin/login', 'AdminsController@login')->name('admin.login');

Route::group(['middleware' => 'auth:admin'], function () {
    // All my routes that needs a logged in admin
    Route::get('/admin', 'AdminsController@home')->name('admin');
    Route::resource('admin-user', 'AdminsController');
    Route::prefix('admin')->group(function(){
        Route::resource('student', 'StudentsController');
        Route::resource('section', 'SectionsController');
    });

});



Route::post('/login', 'HomeController@login')->name('login');
Route::get('/checkUser', 'HomeController@checkUser')->name('checkUser');

//Student
Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::prefix('home')->group(function(){
    });
});
