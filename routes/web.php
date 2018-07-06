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

Route::group(['middleware' => ['web']], function () {
    Route::get('/', [
        'uses' => 'HomeController@index',
        'as' => 'index',
    ]);

    Route::get('/test', [
        'uses' => 'HomeController@index',
        'as' => 'test',
    ]);

    Route::get('hoge', function () {
        return view('hoge');
    });

    Route::get('hogehoge', function () {
        return view('pointer-on-image-test');
    });
});


