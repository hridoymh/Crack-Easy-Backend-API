<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/store', [UserController::class,'store']);
// Route::post('user/create', [UserController::class,'create']);
Route::middleware('gauth')->post('user/create', [UserController::class,'create']);

Route::get('getquestions/cat/{cat}/{count?}/{page?}',[QuestionController::class,'getByCat']);

Route::middleware('gauth')->group(function(){
    // add question
    Route::post('addquestion/',[QuestionController::class,'store']);
    
    // get question list(/count/page)
    Route::post('getquestions/{count?}/{page?}',[QuestionController::class,'index']);
    // get question list by category(/cat/count/page)
    // Route::post('getquestions/cat/{cat}/{count?}/{page?}',[QuestionController::class,'index']);
    // get question list by exam(/xmid/)
    // xm answer 
    // create exam
    // get question 
    // answer
    // get user stat
});

Route::get('getquestions/{count?}/{page?}',[QuestionController::class,'index']);
Route::get('getbycat/{cat}/{count?}/{page?}',[QuestionController::class,'getbycat']);
