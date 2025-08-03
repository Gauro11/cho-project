<?php

namespace App\Imports;

use App\Models\ImmunizationManagement;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImmunizationImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ImmunizationManagement([
            'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date']),
            'vaccine_name' => strtoupper($row['vaccine_name']),
            'male_vaccinated' => (int)$row['male_vaccinated'],
            'female_vaccinated' => (int)$row['female_vaccinated'],
        ]);
    }
}


