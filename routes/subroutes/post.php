<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::controller(PostController::class)
    ->middleware(['auth:sanctum'])
    ->prefix('posts')
    ->group(function (){
        Route::get('/','index')->name('index');
        Route::get('/{id}','show')->name('show');
        Route::post('/','store')->name('store');
        Route::put('/{id}','update')->name('update');
        Route::delete('/{id}','destroy')->name('destroy');
    });
