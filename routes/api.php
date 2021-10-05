<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/unauthorized', function () {
    return response()->json([
        'message' => 'Unauthorized.'
    ], 401);

})->name('login');
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');


Route::apiResource('users', UserController::class)->middleware('auth:sanctum');
Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');
Route::apiResource('/posts/{post}/comments', CommentController::class)->middleware('auth:sanctum');
