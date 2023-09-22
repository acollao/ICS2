<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // or any other middleware you have.
    }

    public function index()
    {
        $project = DB::select('SELECT * FROM `project` where dbase_group IS NOT NULL');
        return view('pages.data.index', [
            'projects' => $project
        ]);
    }

    public function showBoxfilename(Request $request)
    {
        $dbNameGroup = $request->input("dbNameGroup");
        $tblname = $request->input("tblName");
        $dbNameGroup = Helper::RenameDatabaseFileVsActual($dbNameGroup);
        DB::disconnect('mysql'); // dynamic database
        Config::set('database.connections.mysql.database', $dbNameGroup); //new database name, you want to connect to.
        DB::reconnect();

        
        $result = [];

        return response()->json([
            'boxFilenames' => $result,
            'status' => 200,
        ]);
    }

    public function dataEntry(Request $request)
    {
        return view('pages.data.data-entry', [
            'boxFilename' => "qryResult",
            'status' => 200,
        ]);
    }

}
