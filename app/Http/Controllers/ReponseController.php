<?php

namespace App\Http\Controllers;

use App\Models\question;
use App\Models\reponse;
use App\Models\userAnswer;
use Illuminate\Http\Request;

class ReponseController extends Controller
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
        $responses = reponse::all();
        return $responses;
    }

    public function addReponsByQuestion(Request $request,$id){
        $reponse = reponse::create(['rps'=> $request->rps,
                                    'question_id'=> $id]);
    }

    public function addReponses(Request $request){

        $question = question::latest()->first();
        $data = $request->input('reponses');
        $dataSet = [];
        foreach ($data as $reponse) {
          $dataSet[] = [
        'question_id'  => $question->id,
        'rps'    => $reponse['rps'],
        'vrai'       => $reponse['vrai'],
        ];
      }

       $reponses= reponse::insert($dataSet);

    }

    public function addVoteReponse(Request $request){
        $reponse = reponse::where('id',$request->id)->increment('vote');
       }

     public function updateReponses(Request $request){
        $reponses = reponse::where('question_id',$request->id)->update(["vote"=>0]);
       }
       public function addReponse(Request $request){
        $reponse = reponse::create(['question_id'=>$request->id,'rps'=>$request->rps]);
      }
      public function addMultivotes(Request $request){
        $data = $request->input('select');
        foreach ($data as $reponse) {
            $vote = reponse::where('id',$reponse['id'])->increment('vote');
        }
      }

      public function updatReponses(Request $request){
        $reposesSup = reponse::where('question_id',$request->id)->delete();
        $data = $request->input('reponses');
        $dataSet = [];
        foreach ($data as $reponse) {
          $dataSet[] = [
        'question_id'  => $request->id,
        'rps'    => $reponse['rps'],
        'vrai'       => $reponse['vrai'],
        ];
      }

       $reponses= reponse::insert($dataSet);

      }

      //refresh
    public function refreshReponses(){
        $reponses = reponse::where('id','>=',0)->update(["vote"=>0]);
    }

     /* public function addrepAnswer(Request $request){
        $userAnswer = userAnswer::find(6);
        $userAnswer->reponses()->attach($request->reponse_id);
      }*/
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
     * @param  \App\Models\reponse  $reponse
     * @return \Illuminate\Http\Response
     */
    public function show(reponse $reponse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\reponse  $reponse
     * @return \Illuminate\Http\Response
     */
    public function edit(reponse $reponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\reponse  $reponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, reponse $reponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\reponse  $reponse
     * @return \Illuminate\Http\Response
     */
    public function destroy(reponse $reponse)
    {
        //
    }
}
