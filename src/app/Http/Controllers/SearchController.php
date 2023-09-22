<?php

namespace App\Http\Controllers;

use App\Exports\ExportRecord;
use App\Http\Helpers\Helper;
use App\Models\Book;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View as FacadesView;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Stmt\TryCatch;
use Spatie\SimpleExcel\SimpleExcelWriter;

class SearchController extends Controller
{
    protected $dynamicDB;

    public function __construct(Request $request)
    {
        $this->middleware('auth'); // or any other middleware you have.
        // $dbNameGroup = $request->input("dbNameGroup");
        // $this->dynamicDB = App::makeWith('dynamic-db-connection', ['databaseName' => $dbNameGroup]);
    }

    public function index()
    {
        $result = null;
        $headers = null;
        $projects = DB::table('project')
        ->whereNotNull('dbase_group')
        ->get();

        return view('pages.search.index', [
            'projects' => $projects,
            'results' => $result,
            'headers' => $headers
        ]);

    }


    // function queryString(Request $request)
    // {
    //     $dbNameGroup = $request->input("dbNameGroup");
    //     $dbNameGroup = Helper::RenameDatabaseFileVsActual($dbNameGroup);
    //     $tblname = $request->input("tblName");
    //     $field1 = $request->input('field1');
    //     $field2 = $request->input('field2');
    //     $field3 = $request->input('field3');
    //     $fieldValue1 = $request->input('fieldValue1');
    //     $fieldValue2 = $request->input('fieldValue2');
    //     $fieldValue3 = $request->input('fieldValue3');
    //     $operator1 = $request->input('operator1');
    //     $operator2 = $request->input('operator2');
    //     $qry = "";

    //     if (
    //         !empty($field1)
    //         && !empty($fieldValue1)
    //         && !empty($field2)
    //         && !empty($fieldValue2)
    //         && !empty($field3)
    //         && !empty($fieldValue3)
    //     ) {
    //         $qry = "SELECT * FROM `{$dbNameGroup}`.`{$tblname}` WHERE $field1 LIKE '{$fieldValue1}%' 
    //         {$operator1} $field2 LIKE '{$fieldValue2}%' {$operator2} $field3 LIKE '{$fieldValue3}%'";
    //     } else if (
    //         !empty($field1)
    //         && !empty($fieldValue1)
    //         && !empty($field2)
    //         && !empty($fieldValue2)
    //     ) {
    //         $qry = "SELECT * FROM `{$dbNameGroup}`.`{$tblname}` WHERE $field1 LIKE '{$fieldValue1}%' 
    //         {$operator1} $field2 LIKE '{$fieldValue2}%'";
    //     } else if (
    //         !empty($field1)
    //         && !empty($fieldValue1)
    //     ) {
    //         $qry = "SELECT * FROM `{$dbNameGroup}`.`{$tblname}` WHERE {$field1} LIKE '{$fieldValue1}%';";
    //     }

    //     return $qry;
    // }

    function queryString(Request $request)
    {
        $dbNameGroup = $request->input("dbNameGroup");
        $dbNameGroup = Helper::RenameDatabaseFileVsActual($dbNameGroup);
        $tblname = $request->input("tblName");
        $field1 = $request->input('field1');
        $field2 = $request->input('field2');
        $field3 = $request->input('field3');
        $fieldValue1 = $request->input('fieldValue1');
        $fieldValue2 = $request->input('fieldValue2');
        $fieldValue3 = $request->input('fieldValue3');
        $operator1 = $request->input('operator1');
        $operator2 = $request->input('operator2');
        $qry = "";

        if (
            !empty($field1)
            && !empty($fieldValue1)
            && !empty($field2)
            && !empty($fieldValue2)
            && !empty($field3)
            && !empty($fieldValue3)
        ) {
            $qry = "SELECT * FROM `{$dbNameGroup}`.`{$tblname}` WHERE $field1 LIKE '{$fieldValue1}%' 
            {$operator1} $field2 LIKE '{$fieldValue2}%' {$operator2} $field3 LIKE '{$fieldValue3}%'";
        } else if (
            !empty($field1)
            && !empty($fieldValue1)
            && !empty($field2)
            && !empty($fieldValue2)
        ) {
            $qry = "SELECT * FROM `{$dbNameGroup}`.`{$tblname}` WHERE $field1 LIKE '{$fieldValue1}%' 
            {$operator1} $field2 LIKE '{$fieldValue2}%'";
        } else if (
            !empty($field1)
            && !empty($fieldValue1)
        ) {
            $qry = "SELECT * FROM `{$dbNameGroup}`.`{$tblname}` WHERE {$field1} LIKE '{$fieldValue1}%';";
        }

        return $qry;
    }


    function deleteQueryString(Request $request)
    {
        $dbNameGroup = $request->input("dbNameGroup");
        $dbNameGroup = Helper::RenameDatabaseFileVsActual($dbNameGroup);
        $tblname = $request->input("tblName");
        $field1 = $request->input('field1');
        $field2 = $request->input('field2');
        $field3 = $request->input('field3');
        $fieldValue1 = $request->input('fieldValue1');
        $fieldValue2 = $request->input('fieldValue2');
        $fieldValue3 = $request->input('fieldValue3');
        $operator1 = $request->input('operator1');
        $operator2 = $request->input('operator2');
        $qry = "";

        if (
            !empty($field1)
            && !empty($fieldValue1)
            && !empty($field2)
            && !empty($fieldValue2)
            && !empty($field3)
            && !empty($fieldValue3)
        ) {
            $qry = "DELETE FROM `{$dbNameGroup}`.`{$tblname}` WHERE $field1='{$fieldValue1}' 
            {$operator1} $field2='{$fieldValue2}' {$operator2} $field3='{$fieldValue3}'";
        } else if (
            !empty($field1)
            && !empty($fieldValue1)
            && !empty($field2)
            && !empty($fieldValue2)
        ) {
            $qry = "DELETE FROM `{$dbNameGroup}`.`{$tblname}` WHERE $field1='{$fieldValue1}' 
            {$operator1} $field2='{$fieldValue2}'";
        } else if (
            !empty($field1)
            && !empty($fieldValue1)
        ) {
            $qry = "DELETE FROM `{$dbNameGroup}`.`{$tblname}` WHERE {$field1}='{$fieldValue1}';";
        }

        return $qry;
    }

    public function searchjobname(Request $request)
    {
        $tblname = $request->input("tblName");
        $dbNameGroup = Helper::RenameDatabaseFileVsActual($request->input("dbNameGroup"));
        $connection = App::makeWith('dynamic-db-connection', ['databaseName' => $dbNameGroup]);
        
        if(!empty($request->input('fieldValue1')) && !empty($request->input('fieldValue2')) && !empty($request->input('fieldValue3')))
        {
            if(!empty($request->input('field2')) && !empty($request->input('field2'))){
                $results =  $connection->table($tblname)
                ->where($request->input('field1'), 'LIKE', "{$request->input('fieldValue1')}%")
                ->where($request->input('field2'), 'LIKE', "{$request->input('fieldValue2')}%")
                ->where($request->input('field3'), 'LIKE', "{$request->input('fieldValue3')}%")
                ->select('*')
                ->paginate(10);
            }
        }else if(!empty($request->input('fieldValue1')) && !empty($request->input('fieldValue2'))){
            if(!empty($request->input('field2'))){
                $results =  $connection->table($tblname)
                ->where($request->input('field1'), 'LIKE', "{$request->input('fieldValue1')}%")
                ->where($request->input('field2'), 'LIKE', "{$request->input('fieldValue2')}%")
                ->select('*')
                ->paginate(10);
            }
        }else if(!empty($request->input('fieldValue1'))){
            $results =  $connection->table($tblname)
            ->where($request->input('field1'), 'LIKE', "{$request->input('fieldValue1')}%")
            ->select('*')
            ->paginate(10);
        }
        
        if (empty($results)) {
            return response()->json([
                'error' => "No record found or incorrect search criteria.",
                'status' => 400
            ]);
        }


        if (!empty($results)) {
            $headers = array_keys((array) $results[0]);
        }

        
        if($request->ajax()){
            //return view('pages.search.paginated', compact('results', 'headers'));
            //$results = json_decode(json_encode($results), true);
   
            $view = FacadesView::make('pages.search.paginated', compact('results', 'headers'))->render();
            return response()->json([
                'html' => $view,
                'jobresult' => $results,
                'headers' => $headers,
                'status' => 200,
                'dbname' => $dbNameGroup,
                'tblname' => $tblname
            ]);
        }

        return view('pages.search.index', [
            'results' => $results,
            'headers' => $headers
        ]);
        
    }

    public function edit(Request $request)
    {
        $dbNameGroup = $request->input("dbname");
        $tblname = $request->input("tblname");
        $id = $request->input('id');
        $dbNameGroup = Helper::RenameDatabaseFileVsActual($dbNameGroup);

        DB::disconnect('mysql'); // dynamic database
        Config::set('database.connections.mysql.database', $dbNameGroup); //new database name, you want to connect to.
        DB::reconnect();

        $qryResult = DB::table($tblname)->where('id', '=', $id)->get();
        $fields = Helper::GetTableFieldname($qryResult);
        session()->put(['dbNameGroup' => $dbNameGroup, 'tblname' => $tblname, 'fields' => $fields]);

        return view('pages.search.edit', [
            'result' => $qryResult,
            'fields' => $fields
        ]);
    }

    public function update(Request $request)
    {
        $dbNameGroup = session('dbNameGroup');
        $tblname = session('tblname');
        $dbNameGroup = Helper::RenameDatabaseFileVsActual($dbNameGroup);

        Config::set('database.connections.mysql.database', $dbNameGroup); //new database name, you want to connect to.
        DB::reconnect();
        $query ="";

        $query = "UPDATE `{$tblname}` SET ";
        foreach($request->all() as $index => $field){
            if($index == "_token" || $index == "id") continue;
            $query .= $index . '=' .  "'{$field}',";
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE id=?";
        
        $result = DB::update($query, [$request->id]);
        if ($result > 0) {
            
            // return response()->json([
            //     'message' => "Updated successfully.",
            //     'status' => 200,
            // ]);
            return redirect()->back()->with('status', 'Updated successfully.');
            notify()->success('Updated successfully ⚡️');
        }
        else{
            notify()->error('Unable to save.');
        }
    }

    public function editjobname(Request $request)
    {
        if (auth()->user()->role_id != 1) {
            return response()->json([
                'message' => "Unauthorized transaction.",
                'status' => 401,
            ]);
        }
        $dbNameGroup = $request->input("dbname");
        $tblname = $request->input("tblname");
        $id = $request->input('id');
        $dbNameGroup = Helper::RenameDatabaseFileVsActual($dbNameGroup);

        if (!empty($dbNameGroup) && !empty($tblname) && !empty($id)) {

            DB::disconnect('mysql'); // dynamic database
            Config::set('database.connections.mysql.database', $dbNameGroup); //new database name, you want to connect to.
            DB::reconnect();
            $qryResult = DB::table($tblname)->where('id', '=', $id)->get();

            session()->flash('result', $qryResult); // Store it as flash data.
            session()->flash('fields', Helper::GetTableFieldname($qryResult));
            return redirect('search/edit');

            // return view('pages.search.edit', [
            //     'result' => $qryResult,
            //     'status' => 200
            // ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => "Invalid query",
            ]);
        }
    }

    public function deletejobnameById(Request $request)
    {
        $allowedRoles = [1, 2, 6];
        if (!in_array(auth()->user()->role_id, $allowedRoles)) {
            return response()->json([
                'message' => "Unauthorized transaction.",
                'status' => 401,
            ]);
        }

        $dbNameGroup = $request->input("dbname");
        $tblname = $request->input("tblname");
        $id = $request->input('id');
        $dbNameGroup = Helper::RenameDatabaseFileVsActual($dbNameGroup);
        
        // DB::disconnect('mysql'); // dynamic database
        // Config::set('database.connections.mysql.database', $dbNameGroup); //new database name, you want to connect to.
        // DB::reconnect();
        $qry = "DELETE FROM `{$dbNameGroup}`.`{$tblname}` WHERE id = ?";
        $result = DB::delete($qry, [$id]);

        if ($result > 0) {
            return response()->json([
                'message' => "Deleted successfully.",
                'status' => 200,
            ]);
        }

        return response()->json([
            'error' => "Unable to delete",
            'status' => 400,
        ]);
    }


    public function deletejobname(Request $request)
    {
        $allowedRoles = [1, 2, 6];
        if (in_array(auth()->user()->role_id, $allowedRoles)) {
            return response()->json([
                'message' => "Unauthorized transaction.",
                'status' => 401,
            ]);
        }

        $qry = $this->deleteQueryString($request);
        $result = DB::delete($qry);

        if ($result > 0) {
            return response()->json([
                'message' => "Deleted successfully.",
                'status' => 200,
            ]);
        }

        return response()->json([
            'error' => "Unable to delete",
            'status' => 400,
        ]);
    }

    public function export(Request $request)
    {
        $qry = $this->queryString($request);
        $tblname = $request->input("tblName");
        $result = DB::select($qry);


        if ($result > 0) {
            $datetoday = date('m-d-Y_hia');
            return Excel::download(new ExportRecord($result), "{$tblname}_{$datetoday}.xlsx");
        }
    }

   
}
