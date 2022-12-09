<?php

use Illuminate\Support\Facades\Route;
use Zainburfat\rbac\Http\Controllers\Api\AuthController;

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

Route::group(['namespace' => 'Zainburfat\rbac\Http\Controllers'], function(){

});

Route::post('/signin', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {

    // Route::post('/users', 'Api\UserController@index')->middleware(['scope:user.index']);
    // ->middleware(['scopes:post.index,user.index']);


    // Route::post('/test', function (Request $request) {
    //     if ($request->user()->tokenCan('post.index')) {
    //         return 'Can list posts';
    //     }
    // });
});
