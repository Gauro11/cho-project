<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VitalStatisticTemplateExport implements FromArray, WithHeadings
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
            'year',
            'total_population',
            'total_live_births',
            'total_deaths',
            'infant_deaths',
            'maternal_deaths'
        ];
    }
}
