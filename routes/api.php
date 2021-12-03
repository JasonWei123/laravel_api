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

Route::prefix('broadcasting')
    ->middleware(['log'])
    ->name('broadcasting.')
    ->group(function () {
        Route::any('auth', 'BroadcastingController@auth')->name('broadcasting.auth');
    });



Route::prefix('user')
->namespace('User')
->middleware(['log'])
->name('user.')
->group(function () {
    Route::any('register', 'UserController@register')->name('user.register');
    Route::any('first', 'UserController@first')->name('user.first');
    Route::any('update', 'UserController@update')->middleware('throttle:1,1')->name('user.update');
    Route::any('search', 'UserController@search')->middleware('throttle:60,1')->name('user.search');
});
Route::prefix('user')
    ->namespace('User')
    ->middleware(['log', 'pre_jwt'])
    ->name('user.')
    ->group(function () {
        Route::any('message', 'UserController@message')->name('user.message');
    });


Route::prefix('test')
->namespace('Test')
->middleware(['log'])
->name('test.')
->group(function () {
    Route::any('test', 'TestController@test')->name('test.test');
    Route::any('test1', 'TestController@test1')->name('test.test1');
    Route::any('test2', 'TestController@test2')->name('test.test2');
    Route::any('success', 'TestController@returnSuccess')->name('test.success');
    Route::any('fail', 'TestController@returnFail')->name('test.fail');
});

Route::prefix('auth')
->middleware(['log'])
->name('auth.')
->group(function () {
    Route::any('login', 'AuthController@login')->name('auth.login');
    Route::any('me', 'AuthController@me')->name('auth.me');
    Route::any('logout', 'AuthController@logout')->name('auth.login');
});
