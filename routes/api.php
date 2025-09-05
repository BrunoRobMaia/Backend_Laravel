<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\SuggestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

// Rotas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/top-songs', [SongController::class, 'topSongs']);
Route::post('/suggestions', [SuggestionController::class, 'store']);

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::get('/me', [AuthController::class, 'user']);
  Route::apiResource('songs', SongController::class);
  Route::apiResource('suggestions', SuggestionController::class);
  Route::post('/suggestions/{suggestion}/approve', [SuggestionController::class, 'approve']);
  Route::post('/suggestions/{suggestion}/reject', [SuggestionController::class, 'reject']);

  // Futuras rotas para músicas e sugestões aqui
});
