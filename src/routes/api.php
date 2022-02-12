<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::controller(\App\Application\Api\Post\PostApiController::class)->middleware('mockUser')->prefix('post')->group(function () {
    Route::get('', 'index');
    Route::post('', 'store');
    Route::get('/reply', 'replyPosts');
    Route::post('search', 'search');
});

Route::controller(\App\Application\Api\Post\RepostApiController::class)->middleware('mockUser')->prefix('repost')->group(function (){
    Route::post('', 'store');
});

Route::controller(\App\Application\Api\Post\QuotePostApiController::class)->middleware('mockUser')->prefix('quotepost')->group(function (){
    Route::post('', 'store');
});

Route::controller(\App\Application\Api\User\UserApiController::class)->middleware('mockUser')->prefix('user')->group(function (){
    Route::get('{user}', 'show');
    Route::post('follow/{followered_id}', 'follow');
});
