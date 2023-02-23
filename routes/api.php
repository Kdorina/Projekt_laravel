<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NoteController;


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
//SUBJECTS
Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::get('/subject', [SubjectController::class, "index" ]); 

    Route::delete('/subjects/{id}', [SubjectController::class, "destroy" ]); 
    Route::post('/subjects', [SubjectController::class, "store" ]); 
    Route::put('/subjects/{id}', [SubjectController::class, "update" ]); 
    Route::post('/logout', [AuthController::class, "logout" ]); 

    Route::get('/argAll', [SubjectController::class, "avarageAllSubject" ]);
    Route::get('/arg', [SubjectController::class, "avarageOneSubject" ]); 
    Route::get('/grade', [SubjectController::class, "avgGradeFromAddSubjects" ]); 

});

Route::get('/subjects/{id}', [SubjectController::class, "show" ]); 

Route::post('/register', [AuthController::class, "register" ]); 
Route::post('/login', [AuthController::class, "login" ]); 


//ADMIN
Route::group(['middleware'=>['auth:sanctum']], function(){
    //admin logout
});

// ADMIN API ROUTE/+ADMIN OLDALHOZ 
Route::post('/adminReg', [AdminController::class, "adminRegister" ]); 
Route::post('/adminLog', [AdminController::class, "adminLogin" ]); 

Route::get('/user', [AuthController::class, "getUsers" ]); 
Route::get('/users', [AuthController::class, "showUsers" ]); 
Route::get('/sum', [AuthController::class, "countUsers" ]); 
Route::get('/age', [AuthController::class, "userAvgAge" ]); 
Route::get('/gender', [AuthController::class, "getGenders" ]); 
Route::get('/womens', [AuthController::class, "getWomens" ]); 
Route::get('/mens', [AuthController::class, "getMens" ]); 
Route::get('/else', [AuthController::class, "getElse" ]); 
Route::get('/allBuilding', [AuthController::class, "allBuilding" ]); 

Route::get('/usersSubjects', [SubjectController::class, "usersSubjectsShow" ]); 





//NOTES
Route::group(['middleware'=>['auth:sanctum']], function(){

Route::get('/note', [NoteController::class, 'index']);
// Route::get('/notes/{id}', [NoteController::class, 'show']);
Route::post('/notes', [NoteController::class, 'store']);
Route::delete('/notes/{id}', [NoteController::class, 'destroy']);

});

//FILES
Route::group(['middleware'=>['auth:sanctum']], function(){

Route::get('/image', [FileController::class, 'index']);
// Route::get('/images/{id}', [FileController::class, 'show']);
Route::post('/images', [FileController::class, 'store']);
Route::delete('/images/{id}', [FileController::class, 'destroy']);

});