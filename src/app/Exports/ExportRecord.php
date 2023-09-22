<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportRecord implements FromArray, WithHeadings
{
    protected $records;

    public function __construct(array $records)
    {
        $this->records = $records;
    }

    public function array(): array
    {
        return $this->records;
    }

    public function headings(): array
    {
        $arrays = array();
        $arr = $this->records;

        foreach ($this->records[0] as $key => $value) {
            array_push($arrays, $key);
        }
        //$test = array_keys($this->records[0]);
        //DD($arrays);
        return $arrays;
    }
}
