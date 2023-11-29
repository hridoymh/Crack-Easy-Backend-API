<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;

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
    // get question list by exam(/xmid/)
    // xm answer 
    // create exam
    // answer
    Route::post('anssubmit/',[AnswerController::class,'store']);
    // get user stat
    // edit question
    Route::post('editquestion/{id}',[QuestionController::class,'edit']);

});

Route::get('getquestions/{count?}/{page?}',[QuestionController::class,'index']);
Route::get('getrand/{count?}',[QuestionController::class,'getRand']);
Route::get('getrandbycat/{cat?}/{count?}',[QuestionController::class,'getRandByCat']);
// get question 
Route::get('getquestion/{id}',[QuestionController::class,'getq']);
// get question list by category(/cat/count/page)
Route::get('getbycat/{cat}/{count?}/{page?}',[QuestionController::class,'getbycat']);

Route::get('dropallcat/{id}',function($id){
    $q = \App\Models\Question::find($id);
    $q->categories()->delete();
    return response()->json(['status'=>'done'],200);
});
