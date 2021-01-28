<?php

namespace App\Http\Controllers;

use App\Events\DiffuserEvent;
use App\Models\question;
use App\Models\User;
use App\Models\userAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Question\Question as QuestionQuestion;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getAll(){
        $questions = question::with('responses')->get();
       return $questions;
    }

    public function getresponses($id){
     $reponse = question::find($id)->responses;
     return $reponse;
    }

    public function addQuestion(Request $request){
        $question = question::create(['Qst'=> $request->Qst,'type'=>$request->type]);
    }

    public function deleteQuestion(Request $request){
          $question = question::where('id',$request->id)->delete();
    }

    public function updateSituation(Request $request){
        $questionOff = question::where('situation',1)->update(["situation"=>0]);
        $questionsAnswers = userAnswer::where('question_id',$request->id)->delete();
        $questionOn = question::where('id',$request->id)->update(["situation"=>1,
        'QstVote' => 0,]);

  }
    public function stopShow(){
   $questionOff = question::where('situation',1)->update(["situation"=>0]);
  }

  public function getQuestionOn(){
      $question = question::where('situation',1)->with('responses')->get();
      return $question;
  }

  public function addVoteQuestion(){
    $question = question::where('situation',1)->increment('QstVote');
   }
   public function addMultiVoteQuestion(Request $request){
    $question = question::where('situation',1)->increment('QstVote',$request->nmb);
   }
    public function updateQuestion(Request $request){
        $question = question::where('id',$request->id)->update(["Qst"=>$request->Qst,"situation"=>0,
        'QstVote' => 0,"type"=>$request->type,]);
    }

    public function addTime(Request $request){
        $question = question::where('id',$request->id)->update(["countdown"=>$request->time]);
    }

    //refresh
    public function refreshQuestions(){
        $questions = question::where('id','>=',0)->update(["situation"=>0,
                                       'QstVote' => 0]);
    }


    public function setDate(Request $request){
        $question = question::where('id',$request->id)->update(["time"=>$request->questionCounter]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(question $question)
    {
        //
    }

    public function test(){

        $questions = question::with('responses')->get();
        return view('excel_question', [
            'questions' => $questions->all(),
        ]);

    }

    public function test2(){

        $Users = User::where('admin_key',0)->with('userAnswers')->get();
        foreach ($Users as $user) {
            foreach($user->userAnswers as $answer){
                if($answer->answer == 1){
                    $user['score'] = $user['score'] + 1;
                }
                $time = strtotime($answer->created_at) * 1000;
                $user['scoreTime'] = $user['scoreTime'] + $time;
            }
        }
        $sortedUsers = $Users->sort(function($a, $b) {
            if($a->score === $b->score) {
              if($a->scoreTime === $b->scoreTime) {
                return 0;
              }
              return $a->scoreTime > $b->scoreTime ? 1 : -1;
            }
            return $a->score > $b->score ? -1 : 1;
         });

       return view('excel_user', [
            'users' => $sortedUsers,
        ]);
    }
}
