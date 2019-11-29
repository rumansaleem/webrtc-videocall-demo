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

use App\Events\Ping;

Route::get('login', 'Auth\LoginController@showLoginForm')->middleware('guest')->name('login');
Route::post('login', 'Auth\LoginController@login')->middleware('guest')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->middleware('auth')->name('logout');

Route::get('/', 'WelcomeController')->middleware('auth')->name('index');

Route::middleware('auth')->group(function () {
    Route::post('/video_chats', 'VideoChatController@store')->name('video_chats.store');
    Route::get('/video_chats/{video_chat}/initiate', 'VideoChatController@show')->name('video_chats.initiate');
    Route::get('/video_chats/{video_chat}/join', 'VideoChatController@show')->name('video_chats.join');
});
