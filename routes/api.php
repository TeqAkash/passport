<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\passportAuthController;

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

Route::post('register',[passportAuthController::class,'registerUserExample']);
Route::post('login',[passportAuthController::class,'loginUserExample']);
//add this middleware to ensure that every request is authenticated
Route::middleware('auth:api')->group(function(){
    Route::get('redme', [passportAuthController::class,'authenticatedUserDetails']);
    Route::get('update', [passportAuthController::class,'authenticatedUpdate']);
    Route::post('update', [passportAuthController::class,'nextUpdate']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
