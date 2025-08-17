<?php

namespace App\Imports;

use App\Models\MorbidityMortalityManagement;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MortalityImport implements ToModel, WithHeadingRow
{
    /**
     * Map each row of the Excel file to the database table
     */
    public function model(array $row)
    {
        return new MorbidityMortalityManagement([
         'category' => $row ['category'],
         'case_name'=> $row ['case_name'],
         'date'=> $row      ['date'],
         'male_count'=> $row ['male_count'],
         'female_count'=> $row ['female_count'],
        ]);
    }
}

