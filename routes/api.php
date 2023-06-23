<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Authcontroller;
use App\Http\Controllers\Api\MobileController;
use App\Http\Controllers\Api\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);



Route::middleware('auth:api')->group(function () {
    Route::get('getuser', [AuthController::class, 'userInfo']);
    Route::post('/store', [PostController::class, 'store']);
    Route::get('/index', [PostController::class, 'index']);
    Route::get('/show/{id}', [PostController::class, 'show']);
    Route::post('/update/{id}', [PostController::class, 'update']);
    Route::get('/my_data', [PostController::class, 'my_data']);
    Route::delete('/destroy/{id}', [PostController::class, 'destroy']);

});
