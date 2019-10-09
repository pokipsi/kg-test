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

Route::get('/', function () {
    return view('welcome');
});

Route::get('user/unsubscribe/{id}', "UserController@unsubscribe")->name('unsubscribe')->middleware('signed');
Route::get('user/reactivate/{id}', "UserController@reactivate")->name('reactivate')->middleware('signed');
Route::get('user/reactivated', function(){
    return view('reactivated');
});
Route::get('user/unsubscribed', function(){
    return view('unsubscribed');
});