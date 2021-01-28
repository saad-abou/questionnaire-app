<?php

namespace App\Http\Controllers;

use App\Models\question;
use App\Models\User;
use Illuminate\Http\Request;

class publicResources extends Controller
{
    public function getPublicUser(){
        $user = User::first();
        return $user;
    }

    public function getQuestionPublic(){
        $question = question::where('situation',1)->with('responses')->get();
        return $question;
    }

    public function getAllUsersPublicScore(){
        $Users = User::where('admin_key',0)->with('userAnswers')->get();
       return $Users;
    }
}
