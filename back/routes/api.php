<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('login', [\App\Http\Controllers\UserController::class, 'login']);
Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::post('upload', [\App\Http\Controllers\UploadController::class, 'upload']);

    Route::post('me', [\App\Http\Controllers\UserController::class, 'me']);
    Route::post('logout', [\App\Http\Controllers\UserController::class, 'logout']);
    Route::get('totales', [\App\Http\Controllers\UserController::class, 'totales']);
    Route::put('updatePassword/{user}', [\App\Http\Controllers\UserController::class, 'updatePassword']);
    Route::apiResource('user', \App\Http\Controllers\UserController::class);
    Route::apiResource('materia', \App\Http\Controllers\MateriaController::class);
    Route::apiResource('semestre', \App\Http\Controllers\SemestreController::class);
    Route::apiResource('documento', \App\Http\Controllers\DocumentoController::class);
    Route::apiResource('registro', \App\Http\Controllers\RegistroController::class);
});

