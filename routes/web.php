<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//         return view('welcome');
//     });

Route::get('/', 'HomeController@index')->name('home');

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/post/create', 'PostController@create');
Route::get('/post', 'PostController@index');
Route::get('/post/{post}', 'PostController@show');
Route::post('/post', 'PostController@store');
Route::post('/post/{post}/comment', 'CommentController@store');
// Route::get('/post/{post}', 'PostController@show');

Auth::routes();

// Route::get('/register', 'RegisterController@create');
// Route::post('/register', 'RegisterController@store');

// Route::get('/login', 'SessionController@create');
// Route::post('/login', 'SessionController@store');
Route::get('/logout', 'SessionController@destroy');
Route::post('/logout', 'SessionController@destroy');
