<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

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

Route::group(['middleware'=>['auth:sanctum'], function(){
    Route::post('/newProduct', [ProductController::class, "store" ]); 
    Route::put('/update/{id}', [ProductController::class, "update" ]); 
    Route::delete('/delete/{id}', [ProductController::class, "destroy" ]); 
}]);

Route::post('/register', [AuthController::class, "signUp" ]); 
Route::post('/login', [AuthController::class, "signIn" ]); 
Route::get('/prod', [ProductController::class, "index" ]); 
Route::get('/show/{id}', [ProductController::class, "show" ]); 

