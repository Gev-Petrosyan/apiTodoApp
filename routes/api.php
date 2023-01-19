<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;

Route::group(['middleware' => 'api'], function ($router) {

    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user', [AuthController::class, 'userProfile']);
    });

    Route::group(['prefix' => 'todo'], function ($router) {
        Route::get('/get', [TodoController::class, 'get']);
        Route::get('/get/{id}', [TodoController::class, 'getById']);
        Route::post('/store', [TodoController::class, 'store']);
        Route::post('/delete', [TodoController::class, 'delete']);
        Route::post('/update', [TodoController::class, 'update']);
        Route::post('/active', [TodoController::class, 'active']);
    });   

});
