<?php

namespace App\Imports;

use App\Models\MorbidityMortalityManagement;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class MorbidityImport implements ToModel, WithHeadingRow
{
    /**
     * Map each row of the Excel file to the database table
     */
    public function model(array $row)
    {
        $date = $row['date'];

        // ✅ If it's a number, convert from Excel serial to Y-m-d
        if (is_numeric($date)) {
            $date = ExcelDate::excelToDateTimeObject($date)->format('Y-m-d');
        }

        return new MorbidityMortalityManagement([
            'category'     => $row['category'],
            'case_name'    => $row['case_name'],
            'date'         => $date,
            'male_count'   => $row['male_count'],
            'female_count' => $row['female_count'],
        ]);
    }
}
