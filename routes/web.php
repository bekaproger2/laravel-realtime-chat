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

Route::get('/', 'Auth\LoginController@redirectToLoginPage');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/user')->middleware('auth')->group(function (){
    Route::get('/', 'User\UserController@index')->name('user.profile');
    Route::get('/{user}/edit', 'User\UserController@edit' )->name('user.edit_form');
    Route::post('/{user}/edit', 'User\UserController@update')->name('user.edit');
    Route::get('/verify/{token}', 'User\UserController@verifyUser')->name('user.verify');
    Route::get('/notifications', 'User\UserController@notifications')->name('user.ntfs');
    Route::get('/{user}', 'User\UserController@visit')->name('user.visit');
    
});

Route::get('/users', 'User\UserController@users_list')->middleware('auth')->name('users.list');

Route::resource('/project', 'ProjectController');

Route::resource('/project/{project}/comment', 'CommentController')->middleware('auth');

Route::post('/project/{project}/like', 'ProjectController@like')->name('like');

Route::prefix('chat')->middleware('auth')->group(function(){
    Route::get('/{receiverId}', 'ChatController@index')->where('receiverId', '[0-9]+')->name('chat.room');
    Route::post('/{receiverId}/message', 'ChatController@store')->where('receiverId', '[0-9]+')->name('chat.send');
    Route::get('/', 'ChatController@chatrooms')->name('chat.roomslist');  
});

