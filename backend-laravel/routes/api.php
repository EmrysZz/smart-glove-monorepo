<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TranslationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/translations', [TranslationController::class, 'index'])->middleware('auth:sanctum');
Route::post('/translations', [TranslationController::class, 'store'])->middleware('auth:sanctum');
