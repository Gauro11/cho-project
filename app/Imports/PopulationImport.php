<?php
namespace App\Imports;

use App\Models\Population;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class PopulationImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
         // Remove extra spaces from keys
        $row = array_map('trim', $row);
        
        return new Population([
            'location'   => $row['location'],
            'year_month'       => $this->transformDate($row['year']),
            'population' => $row['population'],
        ]);
    }

   private function transformDate($value)
{
    try {
        // Case 1: Already just a year (e.g. 2025)
        if (is_numeric($value) && strlen((string) $value) === 4) {
            return (int) $value;
        }

        // Case 2: Excel serial date (e.g. 45963)
        if (is_numeric($value)) {
            return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->year;
        }

        // Case 3: String date (e.g. "2025-09-28")
        return Carbon::parse($value)->year;
    } catch (\Exception $e) {
        return null; // if invalid
    }
}


}
