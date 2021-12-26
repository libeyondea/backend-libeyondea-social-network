<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserController;
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

Route::post('auth/signin', [AuthController::class, 'signin']);
Route::post('auth/signup', [AuthController::class, 'signup']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::post('auth/signout', [AuthController::class, 'signout']);

    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/{slug}', [PostController::class, 'show']);
    Route::post('posts', [PostController::class, 'store']);
    Route::put('posts/{slug}', [PostController::class, 'update']);
    Route::delete('posts/{slug}', [PostController::class, 'destroy']);

    Route::post('posts/{slug}/like', [PostLikeController::class, 'like']);
    Route::delete('posts/{slug}/unlike', [PostLikeController::class, 'unlike']);

    Route::get('posts/{slug}/comments', [CommentController::class, 'index']);
    Route::post('posts/{slug}/comments', [CommentController::class, 'store']);
    Route::delete('comments/{slug}', [CommentController::class, 'destroy']);

    Route::post('comments/{slug}/like', [CommentLikeController::class, 'like']);
    Route::delete('comments/{slug}/unlike', [CommentLikeController::class, 'unlike']);

    Route::post('users/{user_name}/follow', [FollowerController::class, 'follow']);
    Route::delete('users/{user_name}/unfollow', [FollowerController::class, 'unfollow']);
    Route::get('users/{user_name}/followers', [FollowerController::class, 'followers']);
    Route::get('users/{user_name}/following', [FollowerController::class, 'following']);

    Route::get('users/{user_name}', [UserController::class, 'show']);

    Route::post('images/upload', [ImageController::class, 'upload']);
});
