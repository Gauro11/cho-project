<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PopulationTemplateExport implements FromArray, WithHeadings
{
     public function array(): array
    {
        return []; // no dummy row needed
    }

    public function headings(): array
    {
        return ['year', 'location', 'population'];
    }
}
