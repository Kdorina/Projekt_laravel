<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\FileController;


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


    Route::delete('/subjects/{id}', [SubjectController::class, "destroy" ]); 
    Route::post('/subjects', [SubjectController::class, "store" ]); 
    Route::put('/subjects/{id}', [SubjectController::class, "update" ]); 
    

});




Route::post('/register', [AuthController::class, "register" ]); 
Route::post('/login', [AuthController::class, "login" ]); 

Route::post('/logout', [AuthController::class, "logout" ]); 

Route::get('/subject', [SubjectController::class, "index" ]); 
Route::get('/subjects/{id}', [SubjectController::class, "show" ]); 
Route::post('/arg', [SubjectController::class, "avarage" ]); 
Route::get('/argAll', [SubjectController::class, "avarageAllSubject" ]); 



Route::get('upload',[FileController::class, 'create']);
Route::post('upload', [FileController::class, 'store']);


// ADMIN API ROUTE
Route::post('/adminReg', [AdminController::class, "adminRegister" ]); 
Route::post('/adminLog', [AdminController::class, "adminLogin" ]); 

Route::get('/user', [AuthController::class, "getUsers" ]); 
Route::get('/users', [AuthController::class, "showUsers" ]); 
Route::get('/sum', [AuthController::class, "countUsers" ]); 
Route::get('/age', [AuthController::class, "userAge" ]); 
Route::get('/gender', [AuthController::class, "getGenders" ]); 
Route::get('/allBuilding', [AuthController::class, "allBuilding" ]); 



//FILES 
Route::get('/allFile', [FileController::class, 'index']);
Route::get('/showFile', [FileController::class, 'show']);
Route::post('/addFile', [FileController::class, 'store']);
Route::put('/updateFile/{id}', [FileController::class, 'update']);
Route::get('/updateFile', [FileController::class, 'update']);