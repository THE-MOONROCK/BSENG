<?php

use App\Http\Controllers\PostController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([], function () {
    // Post module
    Route::get('post/pre-requisite', [PostController::class, 'preRequisite']);
    Route::get('post', [PostController::class, 'index']);
    Route::get('post/{id}', [PostController::class, 'show']);
    Route::post('post', [PostController::class, 'store']);
    Route::post('post/{id}', [PostController::class, 'update']);
    Route::delete('post/{id}', [PostController::class, 'destroy']);
});
