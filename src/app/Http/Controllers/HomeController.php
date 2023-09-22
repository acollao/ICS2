<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // or any other middleware you have.
    }

    public function index()
    {
        $projects = DB::table('project')
            ->select('*')->orderBy('ProjectID', 'desc')->get();
        return view('pages.home.index', [
            'projects' => $projects
        ]);
    }
}
