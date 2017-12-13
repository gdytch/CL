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

        Route::get('student/index-thumb/', 'StudentsController@showThumbnail')->name('student.index.thumb');
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

        Route::resource('exam', 'ExamsController');
        Route::post('exam/generate_papers', 'ExamsController@generate_papers')->name('exam.generate_papers');
        Route::get('exam/{exam_id}/show/student/{id}', 'ExamsController@studentExamPaper')->name('exam.show.student');
        Route::get('exam/active/{id}', 'ExamsController@activeStatus')->name('exam.active');
        Route::get('exam/showtostudents/{id}', 'ExamsController@show_to_students')->name('exam.show_to_students');
        Route::post('exam/savepoints/', 'ExamsController@saveHandsOnPoints')->name('exam.saveHandsOnPoints');
        Route::post('exam/reOpen/', 'ExamsController@reOpen')->name('exam.reOpen');


        Route::post('exam/exam_paper/store', 'ExamsController@exam_paper_store')->name('exam_paper.store');
        Route::get('exam/exam_paper/show/{id}', 'ExamsController@exam_paper_show')->name('exam_paper.show');
        Route::put('exam/exam_paper/update/{id}', 'ExamsController@exam_paper_update')->name('exam_paper.update');
        Route::get('exam/preview/{id}/{page}', 'ExamsController@previewExam')->name('exam.preview');
        Route::post('exam/preview/next', 'ExamsController@NextPage')->name('exam.preview.next');

        Route::post('exam/exam_test/store', 'ExamsController@exam_test_store')->name('exam_test.store');
        Route::put('exam/exam_test/update/{id}', 'ExamsController@exam_test_update')->name('exam_test.update');
        Route::delete('exam/exam_test/delete/{id}', 'ExamsController@exam_test_delete')->name('exam_test.delete');

        Route::post('exam/exam_item/store', 'ExamsController@exam_item_store')->name('exam_item.store');
        Route::put('exam/exam_item/update/{id}', 'ExamsController@exam_item_update')->name('exam_item.update');
        Route::get('exam/exam_item/delete/{id}', 'ExamsController@exam_item_delete')->name('exam_item.delete');

        Route::post('exam/exam_item_choice/store', 'ExamsController@exam_item_choice_store')->name('exam_item_choice.store');
        Route::put('exam/exam_item_choice/update/{id}', 'ExamsController@exam_item_choice_update')->name('exam_item_choice.update');
        Route::get('exam/exam_item_choice/delete/{id}', 'ExamsController@exam_item_choice_delete')->name('exam_item_choice.delete');



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
        Route::get('exam/finish/', 'HomeController@ExamFinish')->name('exam.finish');
        Route::post('exam/next/', 'HomeController@NextPage')->name('exam.next');
        Route::get('exam/{page}/', 'HomeController@exam')->name('exam.open');
        Route::post('exam/submit/', 'HomeController@ExamSubmit')->name('exam.submit');
        Route::get('exam/show/{id}', 'HomeController@showStudentExamPaper')->name('exam.student.show');
        Route::post('settings/avatar', 'HomeController@update_Avatar')->name('student.avatar');
        Route::get('activity/{id}', 'HomeController@showActivity')->name('student.activity.show');
    });
});
