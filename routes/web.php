<?php

use App\Http\Controllers\excelController;
use App\Http\Controllers\publicResources;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReponseController;
use App\Http\Controllers\UserAnswerController;
use App\Http\Controllers\UserController;
use App\Models\userAnswer;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

//getWelcome
Route::get('/', function(){return view('publicPage');})->name('/');
//getSondage
Route::get('/sondage', [App\Http\Controllers\HomeController::class, 'index'])->name('/');
//getQuestion
Route::get('/Questions', [App\Http\Controllers\HomeController::class, 'question']);

Route::resource('questions', QuestionsController::class);
Route::resource('reponses','App\Http\Controllers\ReponsesController');
//getAllQuestions
Route::get('getquestions',[QuestionController::class,'getAll']);
//addQuestion
Route::post('addquestions',[QuestionController::class,'addQuestion']);
//deleteQuestion
Route::post('deleteQuestion',[QuestionController::class,'deleteQuestion']);
//showQuestion
Route::post('updateSituation',[QuestionController::class,'updateSituation']);
Route::post('updateReponses',[ReponseController::class,'updateReponses']);
Route::get('updateUsersVote',[UserController::class,'updateUsersVote']);
//addReponses
Route::post('addreponses',[ReponseController::class,'addReponses']);
//getAllResponses
Route::get('/getresponses',[ReponseController::class,'getAll']);
//getUser
Route::get('getuser',[UserController::class,'getUser']);
//getUserBulletin
Route::get('getUserAnswers',[UserAnswerController::class,'getUserAnswers']);
//getUserBulletin
Route::post('getUsersAnswers',[UserAnswerController::class,'getUsersAnswers']);
//getAllUsers
Route::get('getAllUsers',[UserController::class,'getAllUsers']);
//getAllUsersScore
Route::get('getAllUsersScore',[UserController::class,'getAllUsersScore']);
//getQuetionOn
Route::get('getQuestionOn',[QuestionController::class,'getQuestionOn']);
//vote
Route::post('addVoteQuestion',[QuestionController::class,'addVoteQuestion']);
Route::post('addVoteReponse',[ReponseController::class,'addVoteReponse']);
Route::post('userVote',[UserController::class,'userVote']);
//diffuser
Route::get('diffuser',[UserController::class,'diffuser']);
//diffuser
Route::get('diffuserVote',[UserController::class,'diffuserVote']);
//addReponse
Route::post('addReponse',[ReponseController::class,'addReponse']);
//addMultiReponses
Route::post('addMultivotes',[ReponseController::class,'addMultivotes']);
//addMultiVotesQuest
Route::post('addMultiVoteQuestion',[QuestionController::class,'addMultiVoteQuestion']);
//updateQuestion
Route::post('updateQuestion',[QuestionController::class,'updateQuestion']);
//updateReponses
Route::post('updatReponses',[ReponseController::class,'updatReponses']);
//addTime
Route::post('addTime',[QuestionController::class,'addTime']);
//stopShow
Route::get('stopShow',[QuestionController::class,'stopShow']);
//addAnswer
Route::post('addAnswer',[UserAnswerController::class,'addAnswer']);
//addRepAnswer
//Route::post('addrepAnswer',[ReponseController::class,'addrepAnswer']);
//addAnswer
Route::post('addSelectAnswer',[UserAnswerController::class,'addSelectAnswer']);
//showResult
Route::get('showResult',[UserController::class,'showResult']);
//stopShowResult
Route::get('stopShowResult',[UserController::class,'stopShowResult']);
//diffuserResulta
Route::get('diffuserResult',[UserController::class,'diffuserResult']);

//refresh
Route::get('refreshUsers',[UserController::class,'refreshUsers']);
Route::get('refreshQuestions',[QuestionController::class,'refreshQuestions']);
Route::get('refreshReponses',[ReponseController::class,'refreshReponses']);
Route::get('refreshAnswers',[UserAnswerController::class,'refreshAnswers']);

//getQuestionPublic
Route::get('getQuestionPublic',[publicResources::class,'getQuestionPublic']);
//getPublicUser
Route::get('getPublicUser',[publicResources::class,'getPublicUser']);
//getpublicusersScore
Route::get('getAllUsersPublicScore',[publicResources::class,'getAllUsersPublicScore']);
//setDate
Route::post('setDate',[QuestionController::class,'setDate']);


//exportData
Route::get('export',[excelController::class,'export']);
Route::get('exportUsers',[excelController::class,'exportUsers']);


//test
Route::get('test',[QuestionController::class,'test']);
Route::get('test2',[QuestionController::class,'test2']);




