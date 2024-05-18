<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

Route::post('/v1/auth/signup',[AuthenticationController::class,'signup']);
Route::post('/v1/auth/signin',[AuthenticationController::class,'signin']);
Route::post('/v1/auth/signout',[AuthenticationController::class,'signout'])->middleware(['auth:sanctum']);


Route::get('/v1/auth/admins', [AdminController::class, 'admins'])->middleware(['auth:sanctum', 'checkUserRole']);
Route::post('/v1/auth/users', [AdminController::class, 'users'])->middleware(['auth:sanctum', 'checkUserRole']);
Route::get('/v1/auth/users', [AdminController::class, 'getusers'])->middleware(['auth:sanctum', 'checkUserRole']);
Route::put('/v1/auth/users/{id}', [AdminController::class, 'edituser'])->middleware(['auth:sanctum', 'checkUserRole']);
Route::delete('/v1/auth/users/{id}', [AdminController::class, 'deleteuser'])->middleware(['auth:sanctum', 'checkUserRole']);


