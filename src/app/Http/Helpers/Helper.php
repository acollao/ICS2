<?php
namespace App\Http\Helpers;

class Helper
{
   public static function GetTableFieldname($result_query) : array {
        $arrays = array();
        $arr = $result_query;
        
        foreach ($arr[0] as $key => $value) {
            array_push($arrays, $key);
        }
        return $arrays;
        DD($arrays);
    }


    public static function RenameDatabaseFileVsActual($dbname)
    {
        $fields = array('dbInventoryJstor' => 'dbinventoryJstor');

        $result = isset($fields[$dbname]) ? $fields[$dbname] : $dbname;
        return $result;
    }

    public static function RenameFieldname($key)
    {
        $fields = array('journalTitle' => 'Journal Title', 'issn' => 'ISSN', 'volume' => 'Volume', 
        'dateReceived' => 'Date Received', 'totalpages' => 'Total Pages', 'coverDate' => 'Cover Date', 
    'issueCopyright' => 'Issue Copyright', 'journalId' => 'Journal Id', 'sourceType' => 'Source Type', 
    'publishingLoc' => 'Publishing Loc', 'spiRemarks' => 'SPi Remarks', 'volIssueCount' => 'Vol Issue Count',
    'journalSubTitle' => 'Journal SubTitle', 'journalAbbrevTitle' => 'Journal Abbrev Title', 
    'journalSubject' => 'Journal Subject', 'copyrightYear' => 'Copyright Year', 'publisherName' => 'Publisher Name', 
    'pageStart' => 'Page Start', 'pageEnd' => 'Page End', 'zipFile' => 'Zip File', 'displayOrder' => 'Display Order', 
    'issueTitle' => 'Issue Title', 'jobname' => 'Jobname', 'issue' => 'Issue', 'publisher' => 'Publisher', 
    'spin' => 'SPIN', 'filename' => 'Filename', 'doi' => 'DOI', 'entryBy' => 'Entry By', 'evalBy' => 'Evaluated By', 
    'editBy' => 'Edited By' , 'dateEval' => 'Date Evaluated', 'dateLastEdit' => 'Date Modified', 
    'dateEntered' => 'Date Entered', 'transmittalNo' => 'Transmittal No', 'currentStatus' => 'Current Status', 
    'materialId' => 'Material Id','currDept' => 'Department', 'mccAssignedTo' => 'MCC Assigned To', 
    'mccAssignedTime' => 'MCC Assigned Time', 'mccPersonel' => 'MCC Personel', 'mccRemarks' => 'MCC Remarks', 
    'articleId' => 'Article Id', 'deliveryDate' => 'Delivery Date', 'extra' => 'Extra', 'journalType' => 'Journal Type', 
    'articleTitle' => 'Article Title', 'forwardedSource' => 'Forwarded Source', 'rsd' => 'RSD', 
    'boxFilename' => 'Box Filename', 'completePageRange' => 'Complete Page-Range', 'pdfName' => 'Pdf Name', 
    'reInventory' => 'Re-Inventory', 'dateJobnamed' => 'Date Jobnamed');

        $result = isset($fields[$key]) ? $fields[$key] : $key;
        return $result;
    }
}
