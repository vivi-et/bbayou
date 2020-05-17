<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GiftconTradePostController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//         return view('welcome');
//     });

Auth::routes();


// Route::get('/{giftcon}', 'TestController@show')->name('test');
Route::get('/', 'TestController@index')->name('test');
// Route::get('/', 'HomeController@index')->name('home');
Route::get('/giftcon/mygiftcons', 'GiftconController@mygiftcons');
Route::post('/ajax/saveImage', 'AjaxUploadController@saveImage')->name('ajax.saveImage');
Route::post('/ajax/makeTrade', 'AjaxUploadController@makeTrade')->name('ajax.makeTrade');
Route::post('/giftcon/action', 'AjaxUploadController@action')->name('ajaxupload.action');
Route::post('/giftcon/crop', 'AjaxUploadController@crop')->name('ajaxupload.crop');
Route::post('/comment/make/{post}', 'CommentController@store');

Route::get('/board/{board}', 'BoardController@index');
Route::get('/post/create/{board}', 'PostController@create');

// Route::get('/giftcon/trade/{$trade}', 'GiftconTradePostController@show');
Route::resource('/giftcon/trade', 'GiftconTradePostController');
Route::resource('/giftcon/tradecomment', 'GiftconTradeCommentController');
// Route::resource('/giftcon/tradecommentaccept', 'GiftconTradeCommentController@accept');
Route::resource('/comment', 'CommentController');
Route::resource('/post', 'PostController');
Route::resource('/giftcon', 'GiftconController');


Route::get('/logout', 'SessionController@destroy');
Route::post('/logout', 'SessionController@destroy');
