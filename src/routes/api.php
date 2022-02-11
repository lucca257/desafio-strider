<?php

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

Route::controller(\App\Application\Api\Post\PostApiController::class)->prefix('post')->group(function () {
    Route::get('', 'index');
    Route::post('', 'store');
    Route::get('/reply', 'replyPosts');
});

Route::controller(\App\Application\Api\User\UserApiController::class)->prefix('user')->group(function (){
    Route::get('{user}', 'show');
});
