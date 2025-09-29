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
            'year'       => $this->transformDate($row['year']),
            'population' => $row['population'],
        ]);
    }

   private function transformDate($value)
{
    try {
        if (is_numeric($value)) {
            return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->year;
        }
        return Carbon::parse($value)->year;
    } catch (\Exception $e) {
        return null; // if date is invalid
    }
}

}
