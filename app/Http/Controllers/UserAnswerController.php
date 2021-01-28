<?php

namespace App\Http\Controllers;

use App\Models\reponseUserAnswer;
use App\Models\userAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAnswerController extends Controller
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

    public function addAnswer(Request $request){
        $userAnser = userAnswer::create(['answer'=> $request->answer,
                                         'user_id'=>$request->user_id,
                                         'question_id'=>$request->question_id,
        ])->reponses()->attach($request->reponse_id);
    }

    public function addSelectAnswer(Request $request){
        $userAnser = userAnswer::create(['answer'=> $request->answer,
                                         'user_id'=>$request->user_id,
                                         'question_id'=>$request->question_id,
        ]);
        $data = $request->input('reponses');
        foreach ($data as $reponse) {
            $userAnser->reponses()->attach($reponse['id']);
        }
    }

    public function getUserAnswers(){
        $userAnswers = userAnswer::where('user_id',Auth::user()->id)->with('reponses','question','question.responses')->get();
        return $userAnswers;
    }

    public function getUsersAnswers(Request $request){
        $userAnswers = userAnswer::where('user_id',$request->id)->with('reponses','question','question.responses')->get();
        return $userAnswers;
    }


    public function refreshAnswers(){
        $userAnswers = userAnswer::where('id','>=',0)->delete();

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
     * @param  \App\Models\userAnswer  $userAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(userAnswer $userAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\userAnswer  $userAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(userAnswer $userAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\userAnswer  $userAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, userAnswer $userAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\userAnswer  $userAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(userAnswer $userAnswer)
    {
        //
    }
}
