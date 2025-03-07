<?php

// routes/api.php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TechnologieController;
use App\Http\Controllers\ProjectTechnologieController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\AuthController;

Route::apiResource('projects', ProjectController::class);
Route::apiResource('tasks', TaskController::class);
Route::apiResource('technologies', TechnologieController::class);
Route::apiResource('translations', TranslationController::class);

Route::post('projects/{project}/technologies', [ProjectTechnologieController::class, 'store']);
Route::delete('projects/{project}/technologies/{technologie}', [ProjectTechnologieController::class, 'destroy']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');



