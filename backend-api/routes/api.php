<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckModuleActive;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\UrlShortenerController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get("/s/{code}", [UrlShortenerController::class, "show"]);

Route::group(['middleware' => ['auth:sanctum', 'api']], function(){
  
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('/modules', [ModuleController::class, "index"]);
    Route::post('/modules/{id}/activate', [ModuleController::class, "activate"]);
    Route::post('/modules/{id}/desactivate', [ModuleController::class, "desactivate"]);

    Route::group(['middleware' => [CheckModuleActive::class]], function(){
        Route::post("/shorten", [UrlShortenerController::class, "store"]);
        Route::get("/links", [UrlShortenerController::class, "index"]);        
        Route::delete("/links/{id}", [UrlShortenerController::class, "destroy"]);
    });

});

