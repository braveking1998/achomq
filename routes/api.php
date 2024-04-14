<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Guests
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/reset', [PasswordResetController::class, 'store']);
Route::put('/reset', [PasswordResetController::class, 'update']);

// Auth
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('category', CategoryController::class)->only('index');
    Route::apiResource('level', LevelController::class)->only('index');
    Route::apiResource('question', QuestionController::class)->only(['index', 'show', 'store']);
});

// Admin

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
