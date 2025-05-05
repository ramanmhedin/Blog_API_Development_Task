<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

foreach (glob(__DIR__ . '/subroutes/*.php') as $routeFile) {
    require $routeFile;
}
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
