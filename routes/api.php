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
    // Home
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

    // Operations
    Route::get('screen_shot', [
        'uses' => 'Api\OperationsController@screenshot',
        'as' => 'api.screen.shot'
    ]);
    Route::post('/screen_shot', [
        'uses' => 'Api\OperationsController@uploadScreenShot',
        'as' => 'api.upload.screen.shot',
    ]);

});
