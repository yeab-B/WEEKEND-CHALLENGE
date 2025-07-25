<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MoviesController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RateController;

Route::middleware('auth:sanctum')->group(function () {
    // Movies
    Route::get('/movies', [MoviesController::class, 'index']);
    Route::get('/movies/{id}', [MoviesController::class, 'show']);
    Route::post('/movies', [MoviesController::class, 'store'])->middleware('role:admin');
    Route::put('/movies/{id}', [MoviesController::class, 'update'])->middleware('role:admin');
    Route::delete('/movies/{id}', [MoviesController::class, 'destroy'])->middleware('role:admin');

    // Comments
    Route::post('/comments', [CommentController::class, 'store']);
    Route::get('/movies/{movieId}/comments', [CommentController::class, 'index']);

    // Ratings
    Route::post('/ratings', [RateController::class, 'store']);
    Route::get('/movies/{movieId}/ratings', [RateController::class, 'index']);
});


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});
