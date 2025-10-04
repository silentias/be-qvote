<?php

use App\Http\Controllers\AnswersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\VoiceController;
use App\Http\Middleware\UserAuth;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
	Route::prefix('user')->group(function () {
		Route::post('/login', [UserController::class, 'login']);
		Route::post('/token/verify', [TokenController::class, 'verify']);
	});
	Route::prefix('questions')->group(function () {
		Route::post('/', [QuestionsController::class, 'store'])->middleware(UserAuth::class);
		Route::get('/', [QuestionsController::class, 'index']);
		Route::get('/{id}', [QuestionsController::class, 'show']);
	});
	Route::prefix('answers')->group(function () {
		Route::post('/', [AnswersController::class, 'store'])->middleware(UserAuth::class);
	});
	Route::prefix('voices')->group(function () {
		Route::post('', [VoiceController::class, 'store'])->middleware(UserAuth::class);
	});
});
