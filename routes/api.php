<?php

use App\Http\Controllers\v1\CategoryController;
use App\Http\Controllers\v1\CommentController;
use App\Http\Controllers\v1\LikeController;
use App\Http\Controllers\v1\ProductController;
use App\Http\Controllers\v1\UserController;
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

Route::prefix('v1')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

    Route::post('/like', [LikeController::class, 'like']);

    Route::get('/comments', [CommentController::class, 'comments']);
    Route::post('/add-comment', [CommentController::class, 'add_comment']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/change-password', [UserController::class, 'changePassword']);
        Route::post('/logout', [UserController::class, 'logout']);

        Route::middleware(['admin'])->group(function () {
            Route::get('/users', [UserController::class, 'users']);

            Route::resource('/product', ProductController::class);

            Route::resource('/category', CategoryController::class);
        });
    });
});


