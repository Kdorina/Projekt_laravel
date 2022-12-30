<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubjectController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::post('/subjects', [SubjectController::class, "store" ]); 
    Route::put('/subjects/{id}', [SubjectController::class, "update" ]); 
    Route::delete('/subjects/{id}', [SubjectController::class, "destroy" ]); 
});

Route::post('/register', [AuthController::class, "register" ]); 
Route::post('/login', [AuthController::class, "login" ]); 
Route::get('/subject', [SubjectController::class, "index" ]); 
Route::get('/subjects/{id}', [SubjectController::class, "show" ]); 

