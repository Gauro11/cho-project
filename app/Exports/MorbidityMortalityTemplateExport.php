<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MorbidityMortalityTemplateExport implements FromArray, WithHeadings
{
    /**
     * Return an empty array so no dummy row is added
     */
    public function array(): array
    {
        return []; // no dummy row needed
    }

    /**
     * Set headings for the template
     */
    public function headings(): array
    {
        return [
            'category',
        'case_name',
        'date',
        'male_count',
        'female_count',
        ];
    }
}
