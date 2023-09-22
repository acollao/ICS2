<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class TemplateExport implements FromArray
{

    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function array(): array
    {
        return $this->fields;
    }
}
