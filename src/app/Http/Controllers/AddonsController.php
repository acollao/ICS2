<?php

namespace App\Http\Controllers;

use Adldap\Models\Events\Saved;
use App\Exports\TemplateExport;
use App\Http\Helpers\Helper;
use App\Models\Template;
use App\Models\Uploaded;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AddonsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // or any other middleware you have.
    }

    public function index()
    {
        $project = DB::select('SELECT * FROM `project` where dbase_group IS NOT NULL');
        return view('pages.addons.index', [
            'projects' => $project,
            'tblname' => 'none'
        ]);
    }

    public function getTemplate(Request $request)
    {
       // Get variables from AJAX data
        $dbNameGroup = Helper::RenameDatabaseFileVsActual($request->input("dbNameGroup"));
        $tblName = $request->input("tblName");
        $projectId = $request->input("projectId");

        // Get all available templates for the selected project
        $templates = Template::where('project_id', $projectId)->get();

        // Dynamically switch to the new database
        $this->switchDatabaseConnection($dbNameGroup);
        // Select all fields from the selected project
        $qryResult = DB::select("SELECT * FROM {$tblName} LIMIT 1");
        $fields = Helper::GetTableFieldname($qryResult);

        return response()->json([
            'status' => 200,
            'message' => "Success",
            'fields' => $fields,
            'templates' => $templates,
        ]);

    }

    public function createTemplate(Request $request){
        $fields = $request->input('fields');
        $dbNameGroup = $request->input("project_db");
        $tblname = $request->input("project_tbl");
        $project_id = $request->input("projectId");
        $current = Carbon::now();
        $templateFilename = $tblname . $current->format('YmdHms') . "_template.xlsx";
        // save to db
        try {
            $test = new Template;
            $test->project_id = $project_id;
            $test->template = $templateFilename;
            $test->created_by = auth()->user()->username;
            $test->date_created = $current->toDateTimeString();
            $test->save();
        } catch (\Exception  $e) {
            DD($e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => "Internal Server Error",
            ]);
        }

        // create excel and store in disk
        $filename = $templateFilename;
        $this->exportTemplate($fields, $filename);
       
        //download to client side
        $this->download($filename);
        // get all available template for selected project
        $templates = Template::where('project_id',$project_id)->get();
        
        return response()->json([
            'status' => 200,
            'message' => "Success",
            'templates' => $templates
        ]);
    }

    public function exportTemplate($fields, $filename){
        $export = new TemplateExport([
            $fields
        ]);

        Excel::store($export, $filename, 'template');
    }

    public function download($filename)
    {
        $filename = $filename;
        if (Storage::disk('template')->exists($filename)) {
            return Storage::disk('template')->download($filename);
        }
        else{
            DD('Not exist');
        }
    }

    public function downloadFile(Request $request)
    {
        $filename = $request->input('filename');
        
        if (Storage::disk('template')->exists($filename)) {
            return Storage::disk('template')->download($filename);
        }
        else{
            DD('Not exist');
        }
    }

    public function upload(Request $request)
    {
        $dbNameGroup = $request->input("dbNameGroup");
        $dbNameGroup = Helper::RenameDatabaseFileVsActual($request->input("dbNameGroup"));
        $tblname = $request->input("tblName");
        $currentDatetime = Carbon::now();
        $connection = App::makeWith('dynamic-db-connection', ['databaseName' => $dbNameGroup]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalFilename = $file->getClientOriginalName();
            // Parse the Excel file and convert to DataTable
            $data = Excel::toArray([],$file)[0];

            // Get the header row
            $header = array_shift($data);
            
            // Check for 'dateEntered' field
            $response = $this->checkField($header, 'dateEntered');
            if ($response) {
                return $response;
            }

            // Check for 'entryBy' field
            $response = $this->checkField($header, 'entryBy');
            if ($response) {
                return $response;
            }

            // Initialize an array to store the filtered data
            $filteredData = [];
            $filteredData = $this->filteredData($data, $header);
            // sanitize filtered data here
            $result = $this->sanitizeFilteredData($filteredData);
            if(!empty($result)){
                return response()->json([
                    'status' => 400,
                    'message' => 'Special character found. Please remove. ' . $result,
                ]);
            }
            // insert db code here
            $dbInsert = false;
            try {
                // Start a database transaction
                DB::beginTransaction();

                foreach ($filteredData as $index => $innerArray) {
                    foreach ($innerArray as $key => $value) {
                        $innerArray[$key] = $this->sanitizeFields($key, $value);
                    }

                    // Insert data into the database within the transaction
                    $dbInsert = $connection->table($tblname)->insert($innerArray);

                }
                // Commit the transaction if all insertions were successful
                DB::commit();
            } catch (\Illuminate\Database\QueryException $e) {
                 // Handle database query exception
                 DB::rollBack();
                
                 Log::error("Database query error: {$e->getMessage()}");
                 if (str_contains($e->getMessage(), 'too long')) {
                     // Handle the error due to data length
                     return response()->json([
                         'status' => 400,
                         'message' => "Data is too long for one or more fields.",
                     ]);
                 } else {
                     // Handle other database query exceptions
                     Log::error("Database query error: {$e->getMessage()}");
                     return response()->json([
                         'status' => 500,
                         'message' => 'An error occurred while inserting data.',
                     ]);
                 }
            }catch (\Exception $e) {
                // Handle other exceptions
                DB::rollBack();
            
                Log::error("Error: {$e->getMessage()}");
                return response()->json([
                    'status' => 500,
                    'message' => 'An unexpected error occurred.',
                ]);
            }

           
            
            if($dbInsert)
            {
                // save logs
                try {
                    $connection = App::makeWith('dynamic-db-connection', ['databaseName' => 'pacsmain']);

                    // Define the data you want to insert
                    $data = [
                        'date_uploaded' => $currentDatetime->toDateTimeString(),
                        'filename' => $file->getClientOriginalName(),
                        'username' => auth()->user()->username,
                        'ip' =>$this->getIpAddress($request)
                    ];

                    // Use the dynamicDB connection to insert the data
                    $connection->table('uploaded_excel')->insert($data);
                } catch (\Illuminate\Database\QueryException $e) {
                    $dbInsert = false; 
                    Log::error("Database query error: {$e->getMessage()}");
                    return response()->json([
                        'status' => 500,
                        'message' => 'An error occurred while inserting data.',
                    ]);
                } catch (\Exception  $e) {
                    $dbInsert = false;
                    // Handle other exceptions
                    Log::error("Error: {$e->getMessage()}");
                    return response()->json([
                        'status' => 500,
                        'message' => 'An unexpected error occurred.',
                    ]);
                }

                return response()->json([
                    'status' => 200,
                    'message' => "Record successfully save.",
                ]);
            }
        }

    }

    function sanitizeFilteredData($filteredData){
        $res = "";
        foreach ($filteredData as $index => $innerArray) {
            foreach ($innerArray as $key => $value) {
                if($this->checkGarbageCharacter($value)){
                    $res = $value;
                }
            }
        }
        return $res;
    }

    function filteredData($data, $header){
        // Loop through each row in the Excel data
        foreach ($data as $row) {
            // Initialize an array for the filtered row
            $filteredRow = [];

            // Loop through each column and only include non-null columns
            foreach ($header as $index => $column) {
                if ($column !== null) {
                    $filteredRow[$column] = $row[$index];
                }
            }

            // Add the filtered row to the filtered data
            $filteredData[] = $filteredRow;
        }

        return $filteredData;
    }

    function checkField($headerSet, $fieldName) {
        if (!in_array($fieldName, $headerSet)) {
            return response()->json([
                'status' => 500,
                'message' => "$fieldName field is missing. Please add this column.",
            ]);
        }
    }

    // Function to remove null columns from each sub-array
    function removeNullColumns(array &$array) {
        foreach ($array as &$subArray) {
            foreach ($subArray as $key => $value) {
                if ($value === null) {
                    unset($subArray[$key]);
                }
            }
        }
    }

    function checkGarbageCharacter($value){
        $input = $value;
        $pattern = '/[^\x20-\x7E\t\r\n\–\—\’\“\”]/';

        if(empty($value))
            return false;

        if (preg_match($pattern, $input)) {
            return true;
        } else {
            return false;
        }
    }

    function sanitizeFields($fieldName, $val){
        switch (trim($fieldName)) {
            case "sourceType":
                if ($val > 2) {
                    return response()->json([
                        'status' => 500,
                        'message' => "Invalid value ({$val}) of column " . $fieldName,
                    ]);
                }
                break;
            case "dateEntered":
                $val = empty($val) ? "" . date('Y-m-d H:i:s') . "" : "{$val}";
                break;

            case "entryBy":
                if (empty($val)) {
                    $user = auth()->user();
                    $username = $user ? $user->username : 'User not authenticated.';
                    $val = "{$username}";
                }else{
                    $val = "{$val}";
                }
                break;

            case "dateSourceMod":
            case "dateReturnedToClient":
            case "reInventory":
            case "mccAssignedTime":
            case "transmittalNo":
            case "dateLastEdit":
            case "dateEval":
            case "numCopies":
            case "seriesNumber":
                $val = empty($val) ? "NULL" : "{$val}";
                break;
            case "totalpages":
                $val = empty($val) ? "NULL" : "{$val}";
                break;
            case "dateReceived":
                $inputDateString = $val;
                if (empty($inputDateString)) {
                    return response()->json([
                        'status' => 500,
                        'message' => "Date Field should not be empty.",
                    ]);
                }
                $parsedDate = strtotime($inputDateString);
                if ($parsedDate !== false) {
                    $val = "" . date('Y-m-d', $parsedDate) . "";
                } else {
                    return response()->json([
                        'status' => 500,
                        'message' => "Invalid date format of " . $fieldName,
                    ]);
                }
                break;

            default:
                $val = empty($val) ? "NULL" : (strpos($val, "'") !== false ? "{$val}" : "{$val}");
                break;
        }

        return $val;
    }

    function convertExcelDateToTimestamp($excelDate) {
        // Add the number of days to the Unix timestamp of January 1, 1970 (Unix epoch)
        return strtotime('1970-01-01') + ($excelDate * 24 * 60 * 60);
    }

    function getIpAddress(Request $request)
    {
        $ipAddress = $request->ip();
        return $ipAddress;
    }

    function switchDatabaseConnection($databaseName)
    {
        // Disconnect from the default database
        DB::purge('mysql');
        
        // Set the new database name
        Config::set('database.connections.mysql.database', $databaseName);
        
        // Reconnect to the new database
        DB::reconnect();
    }
}
