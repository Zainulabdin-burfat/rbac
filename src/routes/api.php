<?php

use Illuminate\Support\Facades\DB;
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

    Route::get('/testusers', function(){
        return DB::table('users')->all();
    })->middleware('scope:user.index');

});
