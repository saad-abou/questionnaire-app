<?php

namespace App\Http\Controllers;

use App\Events\DiffuserEvent;
use App\Events\DiffuserResult;
use App\Events\DiffuserVoteEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getUser(){
        $user = User::find(Auth::user()->id);
        return $user;
    }

    public function getAllUsers(){
        $Users = User::where('admin_key',0)->get();
       return $Users;
    }

    public function getAllUsersScore(){
        $Users = User::where('admin_key',0)->with('userAnswers')->get();
       return $Users;
    }


    public function userVote(Request $request){
        $user = User::find(Auth::user()->id)->update(["voted"=>1]);
  }

  public function updateUsersVote(){
    $users = User::where('voted',1)->
                   where('admin_key',0)->update(["voted"=>0]);
   }

   public function showResult(){
    $users = User::where('watchresult',0)->update(["watchresult"=>1]);
   }

   //events
   public function diffuser(){
        event(new DiffuserEvent());
       }
    public function diffuserVote(){
        event(new DiffuserVoteEvent());
       }
    public function diffuserResult(){
        event(new DiffuserResult());
       }


    //refresh
    public function refreshUsers(){
     $users = User::where('watchresult',1)->update(["watchresult"=>0]);
     $users = User::where('admin_key','=',0)->update(["voted"=>0]);
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
