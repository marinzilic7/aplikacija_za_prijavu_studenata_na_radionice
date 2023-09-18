<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/registerUser',[UserController::class,'registerUser']);
Route::post('/loginUser',[UserController::class,'loginUser']);


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
