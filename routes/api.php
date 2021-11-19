<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('user')
->namespace('User')
->middleware(['log'])
->name('user.')
->group(function () {
    Route::any('register', 'UserController@register')->name('user.register');
    Route::any('first', 'UserController@first')->name('user.first');
    Route::any('update', 'UserController@update')->middleware('throttle:1,1')->name('user.update');
});
