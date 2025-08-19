<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PopulationStatisticsManagement;
use App\Models\ImmunizationManagement;
use App\Models\VitalStatisticsManagement;
use App\Models\MorbidityMortalityManagement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PopulationExport;
use Barryvdh\DomPDF\Facade\Pdf;




class DownloadController extends Controller
{
    public function exportMortality($type = 'csv')
{
    // ✅ Only morbidity records
    $data = MorbidityMortalityManagement::where('category', 'mortality')->get();

    $totalSum = $data->sum(function ($row) {
        return $row->male_count + $row->female_count;
    });

    if ($type === 'pdf') {
        // --- PDF Export ---
        $html = '
            <h2 style="text-align:center;">Mortality Statistics Report</h2>
            <table border="1" cellspacing="0" cellpadding="5" width="100%">
                <thead>
                    <tr>
                        <th>Cases</th>
                        <th>Male Count</th>
                        <th>Female Count</th>
                        <th>Total Count</th>
                        <th>Percentage</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($data as $row) {
            $totalCount = $row->male_count + $row->female_count;
            $percentage = $totalSum > 0 ? ($totalCount / $totalSum) * 100 : 0;

            $html .= '
                <tr>
                    <td>' . e($row->case_name) . '</td>
                    <td>' . e($row->male_count) . '</td>
                    <td>' . e($row->female_count) . '</td>
                    <td>' . $totalCount . '</td>
                    <td>' . number_format($percentage, 2) . '%</td>
                    <td>' . \Carbon\Carbon::parse($row->date)->format('m-d-Y') . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';

        $pdf = \PDF::loadHTML($html);
        return $pdf->download('mortality_data_' . date('Y-m-d') . '.pdf');
    }

    // --- CSV Export ---
    $filename = "mortality_data_" . date('Y-m-d') . ".csv";
    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Expires" => "0"
    ];

    $callback = function () use ($data, $totalSum) {
        $file = fopen('php://output', 'w');

        // Header row
        fputcsv($file, ['Cases', 'Male Count', 'Female Count', 'Total Count', 'Percentage', 'Date']);

        foreach ($data as $row) {
            $totalCount = $row->male_count + $row->female_count;
            $percentage = $totalSum > 0 ? ($totalCount / $totalSum) * 100 : 0;

            fputcsv($file, [
                $row->case_name,
                $row->male_count,
                $row->female_count,
                $totalCount,
                number_format($percentage, 2) . '%',
                \Carbon\Carbon::parse($row->date)->format('m-d-Y'),
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}



public function exportMorbidity($type = 'csv')
{
     // ✅ Only morbidity records
    $data = MorbidityMortalityManagement::where('category', 'morbidity')->get();
    
    $totalSum = $data->sum(fn($row) => $row->male_count + $row->female_count);

    if ($type === 'pdf') {
        // --- PDF Export ---
        $html = '
            <h2>Morbidity Statistics Report</h2>
            <table border="1" cellspacing="0" cellpadding="5" width="100%">
                <thead>
                    <tr>
                        <th>Cases</th>
                        <th>Male Count</th>
                        <th>Female Count</th>
                        <th>Total Count</th>
                        <th>Percentage</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($data as $row) {
            $totalCount = $row->male_count + $row->female_count;
            $percentage = $totalSum > 0 ? ($totalCount / $totalSum) * 100 : 0;

            $html .= '
                <tr>
                    <td>' . $row->case_name . '</td>
                    <td>' . $row->male_count . '</td>
                    <td>' . $row->female_count . '</td>
                    <td>' . $totalCount . '</td>
                    <td>' . number_format($percentage, 2) . '%</td>
                    <td>' . \Carbon\Carbon::parse($row->date)->format('m-d-Y') . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';

        $pdf = \PDF::loadHTML($html);
        return $pdf->download('morbidity_data_' . date('Y-m-d') . '.pdf');
    }

    // --- CSV Export ---
    $filename = "morbidity_data_" . date('Y-m-d') . ".csv";
    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Expires" => "0"
    ];

    $callback = function () use ($data, $totalSum) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['Cases', 'Male Count', 'Female Count', 'Total Count', 'Percentage', 'Date']);

        foreach ($data as $row) {
            $totalCount = $row->male_count + $row->female_count;
            $percentage = $totalSum > 0 ? ($totalCount / $totalSum) * 100 : 0;

            fputcsv($file, [
                $row->case_name,
                $row->male_count,
                $row->female_count,
                $totalCount,
                number_format($percentage, 2) . '%',
                \Carbon\Carbon::parse($row->date)->format('m-d-Y'),
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}




    public function exportVitalStatistics($type = 'csv')
{
    $data = VitalStatisticsManagement::all();

    if ($type === 'pdf') {
        // Build HTML table directly (similar to Immunization)
        $html = '
            <h2>Vital Statistics Report</h2>
            <table border="1" cellspacing="0" cellpadding="5" width="100%">
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Population</th>
                        <th>Total Live Births</th>
                        <th>Crude Birth Rate</th>
                        <th>Total Deaths</th>
                        <th>Crude Death Rate</th>
                        <th>Infant Deaths</th>
                        <th>Infant Mortality Rate</th>
                        <th>Maternal Deaths</th>
                        <th>Maternal Mortality Rate</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($data as $row) {
            $crudeBirthRate = $row->total_population > 0 ? ($row->total_live_births / $row->total_population) * 1000 : 0;
            $crudeDeathRate = $row->total_population > 0 ? ($row->total_deaths / $row->total_population) * 1000 : 0;
            $infantMortalityRate = $row->total_live_births > 0 ? ($row->infant_deaths / $row->total_live_births) * 1000 : 0;
            $maternalMortalityRate = $row->total_live_births > 0 ? ($row->maternal_deaths / $row->total_live_births) * 100000 : 0;

            $html .= '
                <tr>
                    <td>' . $row->year . '</td>
                    <td>' . $row->total_population . '</td>
                    <td>' . $row->total_live_births . '</td>
                    <td>' . number_format($crudeBirthRate, 2) . '</td>
                    <td>' . $row->total_deaths . '</td>
                    <td>' . number_format($crudeDeathRate, 2) . '</td>
                    <td>' . $row->infant_deaths . '</td>
                    <td>' . number_format($infantMortalityRate, 2) . '</td>
                    <td>' . $row->maternal_deaths . '</td>
                    <td>' . number_format($maternalMortalityRate, 2) . '</td>
                </tr>';
        }

        $html .= '
                </tbody>
            </table>';

        // Generate PDF
        $pdf = Pdf::loadHTML($html);
        return $pdf->download('vital_statistics_data.pdf');
    }

    // --- CSV export ---
    $filename = "vital_statistics_" . date('Y-m-d') . ".csv";
    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Expires" => "0"
    ];

    $callback = function () use ($data) {
        $file = fopen('php://output', 'w');
        fputcsv($file, [
            'Year', 'Population', 'Total Live Births', 'Crude Birth Rate',
            'Total Deaths', 'Crude Death Rate', 'Infant Deaths',
            'Infant Mortality Rate', 'Maternal Deaths', 'Maternal Mortality Rate'
        ]);

        foreach ($data as $row) {
            $crudeBirthRate = $row->total_population > 0 ? ($row->total_live_births / $row->total_population) * 1000 : 0;
            $crudeDeathRate = $row->total_population > 0 ? ($row->total_deaths / $row->total_population) * 1000 : 0;
            $infantMortalityRate = $row->total_live_births > 0 ? ($row->infant_deaths / $row->total_live_births) * 1000 : 0;
            $maternalMortalityRate = $row->total_live_births > 0 ? ($row->maternal_deaths / $row->total_live_births) * 100000 : 0;

            fputcsv($file, [
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

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}







public function exportImmunization($type = 'csv')
{
    $data = ImmunizationManagement::all();
    $estimatedPopulation = 180000;

    if ($type === 'pdf') {
        // Build HTML table directly (like CSV loop)
        $html = '
            <h2>Immunization Report</h2>
            <table border="1" cellspacing="0" cellpadding="5" width="100%">
                <thead>
                    <tr>
                       
                        <th>Year</th>
                        <th>Vaccine Name</th>
                        <th>Male Vaccinated</th>
                        <th>Female Vaccinated</th>
                        <th>Total Vaccinated</th>
                        <th>Coverage</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($data as $row) {
            $totalVaccinated = $row->male_vaccinated + $row->female_vaccinated;
            $coveragePercentage = $estimatedPopulation > 0 
                ? ($totalVaccinated / $estimatedPopulation) * 100 
                : 0;

            $html .= '
                <tr>
                    
                    <td>' . date('Y', strtotime($row->date)) . '</td>
                    <td>' . $row->vaccine_name . '</td>
                    <td>' . $row->male_vaccinated . '</td>
                    <td>' . $row->female_vaccinated . '</td>
                    <td>' . $totalVaccinated . '</td>
                    <td>' . number_format($coveragePercentage, 2) . '%</td>
                </tr>';
        }

        $html .= '
                </tbody>
            </table>';

        // Generate PDF
        $pdf = Pdf::loadHTML($html);
        return $pdf->download('immunization_data.pdf');
    }

    // --- CSV export (unchanged) ---
    $filename = "immunization_data.csv";
    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Expires" => "0"
    ];

    $callback = function () use ($data, $estimatedPopulation) {
        $file = fopen('php://output', 'w');
        fputcsv($file, [ 'Year', 'Vaccine Name', 'Male Vaccinated', 'Female Vaccinated', 'Total Vaccinated', 'Coverage']);

        foreach ($data as $row) {
            $totalVaccinated = $row->male_vaccinated + $row->female_vaccinated;
            $coveragePercentage = $estimatedPopulation > 0 ? ($totalVaccinated / $estimatedPopulation) * 100 : 0;

            fputcsv($file, [
                
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





   public function exportPopulation($type = 'csv')
{
    $data = PopulationStatisticsManagement::all();

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
    ];

    if ($type === 'pdf') {
        // --- PDF Export ---
        $html = '
            <h2>Population Statistics Report</h2>
            <table border="1" cellspacing="0" cellpadding="5" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Barangay</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Population</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($data as $row) {
            $lat = $barangayCoordinates[$row->location]['lat'] ?? 'N/A';
            $lng = $barangayCoordinates[$row->location]['lng'] ?? 'N/A';

            $html .= '
                <tr>
                    <td>' . $row->id . '</td>
                    <td>' . $row->location . '</td>
                    <td>' . $lat . '</td>
                    <td>' . $lng . '</td>
                    <td>' . $row->population . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';

        $pdf = \PDF::loadHTML($html);
        return $pdf->download('barangay_population.pdf');
    }

    // --- CSV Export ---
    $filename = "barangay_data_" . date('Y-m-d') . ".csv";
    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Expires" => "0"
    ];

    $callback = function () use ($data, $barangayCoordinates) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['ID', 'Barangay Name', 'Latitude', 'Longitude', 'Population']);

        foreach ($data as $row) {
            $lat = $barangayCoordinates[$row->location]['lat'] ?? 'N/A';
            $lng = $barangayCoordinates[$row->location]['lng'] ?? 'N/A';

            fputcsv($file, [
                $row->id,
                $row->location,
                $lat,
                $lng,
                $row->population
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}


  public function export()
{
    return $this->exportPopulation();
}


}
