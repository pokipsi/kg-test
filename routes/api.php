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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', "UserController@index");
Route::post('user/register', "UserController@register");
Route::post('user/subscribe', "UserController@subscribe");

Route::post('user/activate', "UserController@activate");
Route::post('user/deactivate', "UserController@deactivate");

Route::get('user/unsubscribe', "UserController@unsubscribe");
Route::get('user/require-reactivation', "UserController@requireReactivation");

