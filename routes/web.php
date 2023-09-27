<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkshopController;
use App\Models\Workshop;
use Illuminate\Support\Facades\Route;


Route::post('/registerUser',[UserController::class,'registerUser']);
Route::post('/loginUser',[UserController::class,'loginUser']);
Route::post('/logout',[UserController::class,'logout']);
Route::get('/isLogged',[UserController::class,'isLogged']);



Route::post('/dodajKategoriju',[CategoryController::class,'dodajKategoriju']);
Route::get('/getCategory',[CategoryController::class,'getCategory']);
Route::post('/deleteCategory/{id}',[CategoryController::class,'deleteCategory']);


Route::post('/dodajRadionicu',[WorkshopController::class,'dodajRadionicu']);
Route::get('/getRadionicu',[WorkshopController::class,'getRadionicu']);
Route::post('/deleteRadionicu/{id}',[WorkshopController::class,'deleteRadionicu']);
Route::post('/urediRadionicu/{id}',[WorkshopController::class,'urediRadionicu']);


Route::post('/dodajPrijavu',[MemberController::class,'dodajPrijavu']);

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
