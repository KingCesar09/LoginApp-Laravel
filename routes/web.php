<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

// GET
Route::get('/users', [UserController::class, 'index']);

// POST
Route::post('/users', [UserController::class, 'store']);

// UPDATE
Route::put('/users/{id}', [UserController::class, 'update']);

// PATCH
Route::patch('/users/{id}', [UserController::class, 'update']);

// DELETE
Route::delete('/users/{id}', [UserController::class, 'destroy']);
