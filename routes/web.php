<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//         return view('welcome');
//     });

Auth::routes();
// Route::get('/{giftcon}', 'TestController@show')->name('test');
Route::get('/', 'TestController@index')->name('test');
// Route::get('/', 'HomeController@index')->name('home');
Route::post('/post/action', 'AjaxUploadController@action')->name('ajaxupload.action');
Route::post('/post/{post}/comment', 'CommentController@store');

// // Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/post/create', 'PostController@create');
// Route::get('/post', 'PostController@index');
// Route::get('/post/{post}', 'PostController@show');
// Route::delete('/post/{post}', 'PostController@destroy');
// Route::post('/post', 'PostController@store');
// Route::get('/post/{post}/edit', 'PostController@edit');
// Route::post('/post/{post}/edit', 'PostController@update');

Route::resource('/post', 'PostController');
Route::resource('/giftcon', 'GiftconController');

// Route::get('/register', 'RegisterController@create');
// Route::post('/register', 'RegisterController@store');

// Route::get('/login', 'SessionController@create');
// Route::post('/login', 'SessionController@store');
Route::get('/logout', 'SessionController@destroy');
Route::post('/logout', 'SessionController@destroy');
