<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BabyController;
use App\Http\Controllers\PartnerController;

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


Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'partner'], function(){
        Route::get('show', [PartnerController::class, 'index']);
        Route::post('invite', [PartnerController::class, 'create']);
        Route::delete('delete', [PartnerController::class, 'destroy']);
    });

    Route::apiResource('babies', BabyController::class);

    Route::post('logout', [AuthController::class, 'logout']);
});

// Register/Login routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
