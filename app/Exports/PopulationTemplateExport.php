<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PopulationTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        // Add one dummy row so Laravel Excel detects headers
        return [
            ['', '', '']
        ];
    }

    public function headings(): array
    {
        return ['date', 'location', 'population'];
    }
}
