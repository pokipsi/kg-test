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

Route::get('email-welcome', function(){
    $data['bodyData'] = [
        'link' => 'http://www.google.com'
    ];
    $data['mailto'] = 'djurkaaleksandar@gmail.com';
    $data['subject'] = 'KG Welcome';
    $data['viewName'] = 'welcome';

    dispatch(new App\Jobs\SendEmailJob($data));
    dd('done');
});

Route::get('email-reactivate', function(){
    $data['bodyData'] = [
        'link' => 'http://www.google.com'
    ];
    $data['mailto'] = 'djurkaaleksandar@gmail.com';
    $data['subject'] = 'KG Reactivation';
    $data['viewName'] = 'reactivate';

    dispatch(new App\Jobs\SendEmailJob($data));
    dd('done');
});