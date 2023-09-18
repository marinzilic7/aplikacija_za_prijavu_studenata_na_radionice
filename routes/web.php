<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/registerUser',[UserController::class,'registerUser']);
Route::post('/loginUser',[UserController::class,'loginUser']);
Route::post('/logout',[UserController::class,'logout']);
Route::get('/isLogged',[UserController::class,'isLogged']);


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
