<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::post('/user_registration', [UserController::class, 'UserRegistration']);
Route::post('/user_login', [UserController::class, 'userLogin']);
