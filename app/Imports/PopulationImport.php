<?php

namespace App\Imports;

use App\Models\PopulationStatisticsManagement; // ✅ Correct model
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PopulationImport implements ToModel, WithHeadingRow, SkipsEmptyRows, SkipsOnError
{
    use SkipsErrors;

    public function model(array $row)
    {
        // Clean up the row data
        $row = array_map(function($value) {
            return is_string($value) ? trim($value) : $value;
        }, $row);

        // Log for debugging
        Log::info('Importing row:', $row);

        // Skip if required fields are empty
        if (empty($row['location']) || empty($row['year_month']) || empty($row['population'])) {
            Log::warning('Skipping row due to missing data:', $row);
            return null;
        }

        return new PopulationStatisticsManagement([
            'location'   => $row['location'],
            'year_month' => $this->transformDate($row['year_month']),
            'population' => (int)$row['population'],
        ]);
    }

    private function transformDate($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            // Case 1: Already in "YYYY-MM" format
            if (is_string($value) && preg_match('/^\d{4}-\d{2}$/', $value)) {
                Log::info("Date already in correct format: $value");
                return $value;
            }

            // Case 2: Just year "2025" -> convert to "2025-01"
            if (is_numeric($value) && strlen((string)$value) === 4) {
                $result = $value . '-01';
                Log::info("Converted year $value to $result");
                return $result;
            }

            // Case 3: Excel serial date
            if (is_numeric($value) && $value > 1000) {
                $date = Carbon::instance(ExcelDate::excelToDateTimeObject($value));
                $result = $date->format('Y-m');
                Log::info("Converted Excel date $value to $result");
                return $result;
            }

            // Case 4: String date like "2025-09-28" or "January 2025"
            $date = Carbon::parse($value);
            $result = $date->format('Y-m');
            Log::info("Parsed date $value to $result");
            return $result;

        } catch (\Exception $e) {
            Log::error('Date transformation error: ' . $e->getMessage() . ' for value: ' . $value);
            return null;
        }
    }
}


