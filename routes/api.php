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

Route::group(['middleware' => ['api']], function () {
    Route::get('/index', [
        'uses' => 'Api\HomeController@index',
        'as' => 'api.index',
    ]);

    Route::get('/list/{date}', [
        'uses' => 'Api\HomeController@list',
        'as' => 'api.list',
    ]);

    Route::get('/show/{date}/{image}', [
        'uses' => 'Api\HomeController@show',
        'as' => 'api.show',
    ]);

    Route::post('/upload', [
        'uses' => 'Api\HomeController@upload',
        'as' => 'api.upload',
    ]);
});
