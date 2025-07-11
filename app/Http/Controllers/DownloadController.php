<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PopulationStatisticsManagement;
use App\Models\ImmunizationManagement;
use App\Models\VitalStatisticsManagement;
use App\Models\MorbidityMortalityManagement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;


class DownloadController extends Controller
{
    public function exportMortality()
    {
        $data = MorbidityMortalityManagement::all(); // Fetch all mortality records

        $csvFileName = 'mortality_data_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$csvFileName\"",
        ];

        // Create a temporary file in memory
        $handle = fopen('php://temp', 'w');

        // Add CSV column headers
        fputcsv($handle, ['Cases', 'Male Count', 'Female Count', 'Total Count', 'Percentage', 'Date']);

        // Calculate total sum for percentage computation
        $totalSum = $data->sum(fn($row) => $row->male_count + $row->female_count);

        foreach ($data as $row) {
            $totalCount = $row->male_count + $row->female_count;
            $percentage = $totalSum > 0 ? ($totalCount / $totalSum) * 100 : 0;

            fputcsv($handle, [
                $row->case_name,
                $row->male_count,
                $row->female_count,
                $totalCount,
                number_format($percentage, 2) . '%',
                Carbon::parse($row->date)->format('m-d-Y'),
            ]);
        }

        // Read the CSV contents and return as response
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csv, 200, $headers);
    }


public function exportMorbidity()
{
    $data = MorbidityMortalityManagement::all(); // Fetch all records

    $csvFileName = 'morbidity_data_' . date('Y-m-d') . '.csv';

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=\"$csvFileName\"",
    ];

    $handle = fopen('php://temp', 'w');
    fputcsv($handle, ['Cases', 'Male Count', 'Female Count', 'Total Count', 'Percentage', 'Date']);

    $totalSum = $data->sum(fn($row) => $row->male_count + $row->female_count);

    foreach ($data as $row) {
        $totalCount = $row->male_count + $row->female_count;
        $percentage = $totalSum > 0 ? ($totalCount / $totalSum) * 100 : 0;

        fputcsv($handle, [
            $row->case_name,
            $row->male_count,
            $row->female_count,
            $totalCount,
            number_format($percentage, 2) . '%',
            \Carbon\Carbon::parse($row->date)->format('m-d-Y'),
        ]);
    }

    rewind($handle);
    $csv = stream_get_contents($handle);
    fclose($handle);

    return Response::make($csv, 200, $headers);
}



    public function exportVitalStatistics()
    {
        $data = VitalStatisticsManagement::all(); // Fetch all records
    
        $csvFileName = 'vital_statistics_' . date('Y-m-d') . '.csv';
    
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$csvFileName\"",
        ];
    
        $handle = fopen('php://temp', 'w');
        fputcsv($handle, [
            'Year', 'Population', 'Total Live Births', 'Crude Birth Rate',
            'Total Deaths', 'Crude Death Rate', 'Infant Deaths',
            'Infant Mortality Rate', 'Maternal Deaths', 'Maternal Mortality Rate'
        ]);
    
        foreach ($data as $row) {
            $crudeBirthRate = $row->total_population > 0 ? ($row->total_live_births / $row->total_population) * 1000 : 0;
            $crudeDeathRate = $row->total_population > 0 ? ($row->total_deaths / $row->total_population) * 1000 : 0;
            $infantMortalityRate = $row->total_live_births > 0 ? ($row->infant_deaths / $row->total_live_births) * 1000 : 0;
            $maternalMortalityRate = $row->total_live_births > 0 ? ($row->maternal_deaths / $row->total_live_births) * 100000 : 0;
    
            fputcsv($handle, [
                $row->year, 
                $row->total_population, 
                $row->total_live_births, 
                number_format($crudeBirthRate, 2), 
                $row->total_deaths, 
                number_format($crudeDeathRate, 2), 
                $row->infant_deaths, 
                number_format($infantMortalityRate, 2), 
                $row->maternal_deaths, 
                number_format($maternalMortalityRate, 2)
            ]);
        }
    
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
    
        return Response::make($csv, 200, $headers);
    }

    public function exportImmunization()
    {
        $data = ImmunizationManagement::all(); // Fetch all immunization data

        $filename = "immunization_data.csv";

        // Set headers to force download
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Expires" => "0"
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, ['ID', 'Year', 'Vaccine Name', 'Male Vaccinated', 'Female Vaccinated', 'Total Vaccinated', 'Coverage']);

            $estimatedPopulation = 180000; // Adjust as necessary

            foreach ($data as $row) {
                $totalVaccinated = $row->male_vaccinated + $row->female_vaccinated;
                $coveragePercentage = $estimatedPopulation > 0 ? ($totalVaccinated / $estimatedPopulation) * 100 : 0;

                fputcsv($file, [
                    $row->id,
                    date('Y', strtotime($row->date)),
                    $row->vaccine_name,
                    $row->male_vaccinated,
                    $row->female_vaccinated,
                    $totalVaccinated,
                    number_format($coveragePercentage, 2) . '%'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPopulation()
{
    $data = PopulationStatisticsManagement::all(); // Fetch all data from the table

    $barangayCoordinates = [
        'Bacayao Norte' => ['lat' => 16.037346, 'lng' => 120.346786],
        'Bacayao Sur' => ['lat' => 16.030672, 'lng' => 120.341251],
        'Barangay I' => ['lat' => 16.044844, 'lng' => 120.335835],
        'Barangay II' => ['lat' => 16.041909, 'lng' => 120.336434],
        'Barangay IV' => ['lat' => 16.041994, 'lng' => 120.335449],
        'Bolosan' => ['lat' => 16.050444, 'lng' => 120.364059],
        'Bonuan Binloc' => ['lat' => 16.101930, 'lng' => 120.379703],
        'Bonuan Boquig' => ['lat' => 16.077498, 'lng' => 120.358025],
        'Bonuan Gueset' => ['lat' => 16.075381, 'lng' => 120.343179],
        'Calmay' => ['lat' => 16.045288, 'lng' => 120.325569],
        'Carael' => ['lat' => 16.031396, 'lng' => 120.313649],
        'Caranglaan' => ['lat' => 16.030648, 'lng' => 120.349915],
        'Herrero-Perez' => ['lat' => 16.043930, 'lng' => 120.342263],
        'Lasip Chico' => ['lat' => 16.021638, 'lng' => 120.340272],
        'Lasip Grande' => ['lat' => 16.028621, 'lng' => 120.343201],
        'Lomboy' => ['lat' => 16.054649, 'lng' => 120.323475],
        'Lucao' => ['lat' => 16.020486, 'lng' => 120.322627],
        'Malued' => ['lat' => 16.029291, 'lng' => 120.335123],
        'Mamalingling' => ['lat' => 16.056642, 'lng' => 120.362212],
        'Mangin' => ['lat' => 16.038877, 'lng' => 120.367335],
        'Mayombo' => ['lat' => 16.041841, 'lng' => 120.346308],
        'Pantal' => ['lat' => 16.046174, 'lng' => 120.338746],
        'Poblacion Oeste' => ['lat' => 16.042353, 'lng' => 120.330374],
        'Pogo Chico' => ['lat' => 16.038643, 'lng' => 120.337509],
        'Pogo Grande' => ['lat' => 16.032503, 'lng' => 120.336519],
        'Salapingao' => ['lat' => 16.057873, 'lng' => 120.319872],
        'Salisay' => ['lat' => 16.041955, 'lng' => 120.371284],
        'Tambac' => ['lat' => 16.046036, 'lng' => 120.356319],
        'Tapuac' => ['lat' => 16.032397, 'lng' => 120.330215],
        'Tebeng' => ['lat' => 16.032023, 'lng' => 120.358877],
        // Add other barangays...
    ];

    $filename = "barangay_data.csv";

    // Set headers to force download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $handle = fopen('php://output', 'w');

    // Add CSV headers
    fputcsv($handle, ['ID', 'Barangay Name', 'Latitude', 'Longitude', 'Population']);

    foreach ($data as $row) {
        $lat = $barangayCoordinates[$row->location]['lat'] ?? 'N/A';
        $lng = $barangayCoordinates[$row->location]['lng'] ?? 'N/A';

        fputcsv($handle, [
            $row->id,
            $row->location,
            $lat,
            $lng,
            $row->population
        ]);
    }

    fclose($handle);
    exit;
}

}
