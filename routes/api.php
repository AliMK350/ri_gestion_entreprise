<?php

use App\Http\Controllers\Api\V1\AbsenceController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EmploiDuTempsController;
use App\Http\Controllers\Api\V1\ModuleController;
use App\Http\Controllers\Api\V1\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        Route::get('/notes', [NoteController::class, 'index']);
        Route::get('/emplois-du-temps', [EmploiDuTempsController::class, 'index']);
        Route::get('/absences', [AbsenceController::class, 'index']);
        Route::get('/modules', [ModuleController::class, 'index']);
    });
});
