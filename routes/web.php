<?php

use App\Http\Controllers\GiftconTradePostController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//         return view('welcome');
//     });

Auth::routes();


// Route::get('/{giftcon}', 'TestController@show')->name('test');
// Route::get('/', 'TestController@index')->name('test');
Route::get('/', 'HomeController@index')->name('home');
Route::post('/giftcon/action', 'AjaxUploadController@action')->name('ajaxupload.action');
Route::post('/giftcon/crop', 'AjaxUploadController@crop')->name('ajaxupload.crop');
Route::post('/post/{post}/comment', 'CommentController@store');

Route::get('/board/{board}', 'BoardController@index');

Route::resource('/giftcon/trade', 'GiftconTradePostController');
Route::resource('/post', 'PostController');


Route::resource('/giftcon', 'GiftconController');

Route::get('/logout', 'SessionController@destroy');
Route::post('/logout', 'SessionController@destroy');
