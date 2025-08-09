<?php

namespace App\Imports;

use App\Models\VitalStatisticsManagement;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VitalStatisticsImport implements ToModel, WithHeadingRow
{
    /**
     * Map each row of the Excel file to the database table
     */
    public function model(array $row)
    {
        return new VitalStatisticsManagement([
            'year' => $row['year'], // make sure your Excel has a 'year' column
            'total_population'  => $row['total_population'],
            'total_live_births' => $row['total_live_births'],
            'total_deaths'      => $row['total_deaths'],
            'infant_deaths'     => $row['infant_deaths'],
            'maternal_deaths'   => $row['maternal_deaths'],
        ]);
    }
}
