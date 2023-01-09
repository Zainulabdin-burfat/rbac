<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;



Route::post('rbac_login', [AuthController::class, 'login']);

Route::post('rbac_register', [AuthController::class, 'register']);