<?php

namespace App\Http\Controllers;

use App\Exports\QuestionsExport;
use App\Exports\UserExport;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class excelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function export()
    {
        return Excel::download(new QuestionsExport, 'Questions.xlsx');
    }
    public function exportUsers()
    {
        return Excel::download(new UserExport, 'UsersScore.xlsx');
    }
}
