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
Route::post('/admin/store_first', 'AdminsController@store_first')->name('admin.store_first');


Route::group(['middleware' => 'auth:admin'], function () {
    // All my routes that needs a logged in admin
    Route::get('/admin', 'AdminsController@home')->name('admin');
    Route::resource('admin-user', 'AdminsController');
    Route::prefix('admin')->group(function(){
        Route::get('settings', 'AdminsController@settings')->name('admin.settings');
        Route::get('theme', 'AdminsController@theme')->name('admin.theme');
        Route::post('filetyperules', 'AdminsController@filetype_rule_store')->name('filetype_rule.store');
        Route::put('filetyperules/{id}', 'AdminsController@filetype_rule_update')->name('filetype_rule.update');
        Route::delete('filetyperules/{id}', 'AdminsController@filetype_rule_delete')->name('filetype_rule.delete');
        Route::put('update_password/{id}', 'AdminsController@update_password')->name('admin.update.password');

        Route::resource('student', 'StudentsController');
        Route::get('student/folder/{id}', 'StudentsController@folder')->name('student.folder');
        Route::put('student/update_password/{id}', 'StudentsController@update_password')->name('student.update.password');
        Route::post('student/create/batch', 'StudentsController@batch')->name('student.create.batch');

        Route::resource('section', 'SectionsController');
        Route::get('section/status/{id}', 'SectionsController@changeStatus')->name('section.status');
        Route::get('section/folder/{id}', 'SectionsController@folder')->name('section.folder');

        Route::resource('post', 'PostsController');

        Route::resource('activity', 'ActivitiesController');
        Route::get('activity/status/{id}', 'ActivitiesController@changeStatus')->name('activity.status');
        Route::get('activity/submission/{id}', 'ActivitiesController@changeSubmissionStatus')->name('activity.submission');


    });

});


Route::resource('file', 'FilesController');
Route::post('login', 'HomeController@login')->name('login');
Route::get('checkUser', 'HomeController@checkUser')->name('checkUser');

//Student
Route::group(['middleware' => 'auth:web'], function () {
    Route::get('home', 'HomeController@index')->name('home');
    Route::prefix('home')->group(function(){
        Route::get('trash', 'HomeController@trash')->name('trash');
        Route::put('update_password/{id}', 'HomeController@update_password')->name('update.password');
        Route::get('settings', 'HomeController@settings')->name('student.settings');
        Route::get('profile', 'HomeController@profile')->name('student.profile');
        Route::get('theme', 'StudentsController@theme')->name('student.theme');
        Route::get('activity', 'HomeController@activity')->name('student.activity');
    });
});


Route::get('/test', function(){
    return view('dashboards.test');
});
