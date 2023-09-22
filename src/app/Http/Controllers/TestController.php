<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Models\Book;
use App\Models\DynamicModel;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function testModel()
    {

        print(date("Y"));
        // $res = Helper::RenameFieldname('copyrightYear');
        // $test = strlen("sdasdasdasd");
        // if($test > 2)
        // {
        //     print("false");
        // }
        // print($res);
    }

    

    public function test()
    {
        $databaseName = 'dbInventoryStatJournals';
        $tableName = 'tblOlchDataItems';
        $connection = App::makeWith('dynamic-db-connection', ['databaseName' => $databaseName]);
        // Use the dynamicDB connection for queries
        $query = $connection->table($tableName)->select('*')->orderByDesc('id')->paginate(10);
        
        // Paginate the data manually
        // $perPage = 10; // Number of items per page
        // $currentPage = request()->input('page', 1); // Get the current page from the URL query parameter

        // $currentItems = array_slice($query, ($currentPage - 1) * $perPage, $perPage);

        if (!empty($query)) {
            $headers = array_keys((array) $query[0]);
        }

        return view('test',[
            'headers' =>  $headers,
            'results' =>  $query
        ]);
    }

    public function index()
    {
        return view('test');
    }

    public function fetch(Request $request)
    {
        $items = User::paginate(5); // Adjust the number of items per page as needed
        return view('pagination', compact('items'));
    }
}
