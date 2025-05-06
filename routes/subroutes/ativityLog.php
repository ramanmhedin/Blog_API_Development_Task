<?php

use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

Route::controller(ActivityLogController::class)
    ->middleware('auth:sanctum')
    ->prefix('activity-log')
    ->group(function (){
        Route::get('/','index')->name('index');
    });
