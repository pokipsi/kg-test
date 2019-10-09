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
Route::post('user/check', "UserController@check");
Route::post('user/register', "UserController@register");
Route::post('user/subscribe', "UserController@subscribe");
Route::post('user/require-reactivation', "UserController@requireReactivation");

Route::post('user/activate', "UserController@activate");
Route::post('user/deactivate', "UserController@deactivate");

//PayPal
Route::post('paypal/order/create', "PayPalController@create");
Route::post('paypal/order/capture', "PayPalController@capture");
Route::post('paypal/return', function(){})->name("paypal-return");
Route::post('paypal/cancel', function(){})->name("paypal-cancel");



