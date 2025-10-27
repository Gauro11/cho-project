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
            'date' => $row['date'] ?? now(),
            'vaccine_name' => $row['vaccine_name'] ?? '',
            'vaccine_type' => $row['vaccine_type'] ?? '',
            'total_shots' => $row['total_shots'] ?? 0,
            'male_vaccinated' => $row['male_vaccinated'] ?? 0,
            'female_vaccinated' => $row['female_vaccinated'] ?? 0,
            'age_group' => $row['age_group'] ?? '',
            'target_population' => $row['target_population'] ?? null,
            'barangay' => $row['barangay'] ?? '',
        ]);
    }


    private function normalizeDate($value): ?string
    {
        if ($value === null || $value === '') return null;

        // If PhpSpreadsheet already produced a DateTime
        if ($value instanceof \DateTimeInterface) {
            return (new \DateTimeImmutable($value->format('c')))
                ->setTimezone(new \DateTimeZone('Asia/Manila'))
                ->format('Y-m-d');
        }

        // Trim strings
        $v = is_string($value) ? trim($value) : $value;

        // Pure 4-digit year (string like "2025" or numeric 2025)
        if (
            (is_string($v) && preg_match('/^\d{4}$/', $v)) ||
            (is_numeric($v) && strlen((string) (int) $v) === 4 && (int) $v >= 1900 && (int) $v <= 2500)
        ) {
            // choose canonical day; change to '-12-31' if you prefer
            return ((string) (int) $v) . '-01-01';
        }

        // Excel serial date (typical range); skip the early-leap bug zone
        if (is_numeric($v) && (int)$v > 59 && (int)$v < 70000) {
            return ExcelDate::excelToDateTimeObject((int)$v)
                ->setTimezone(new \DateTimeZone('Asia/Manila'))
                ->format('Y-m-d');
        }

        // Text dates like "2025-08-14", "Aug 14, 2025", "14/08/2025"
        try {
            return (new \DateTimeImmutable((string) $v, new \DateTimeZone('Asia/Manila')))->format('Y-m-d');
        } catch (\Throwable $e) {
            return null; 
        }
    }
}



