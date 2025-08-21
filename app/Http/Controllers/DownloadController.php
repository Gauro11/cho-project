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
        // --- PDF export (unchanged) ---
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

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
        return $pdf->download('vital_statistics_data.pdf');
    }

    // --- CSV export (DB-like format) ---
    $filename = "vital_statistics_" . date('Y-m-d') . ".csv";
    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Expires" => "0"
    ];

    $callback = function () use ($data) {
        $file = fopen('php://output', 'w');

        if ($data->isNotEmpty()) {
            // Use the model fillable fields as headers
            $columns = (new \App\Models\VitalStatisticsManagement)->getFillable();

            // Write DB-like headers
            fputcsv($file, $columns);

            // Write rows
            foreach ($data as $row) {
                $rowData = [];
                foreach ($columns as $col) {
                    $rowData[] = $row->$col;
                }
                fputcsv($file, $rowData);
            }
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
        // --- PDF export (unchanged) ---
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

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
        return $pdf->download('immunization_data.pdf');
    }

    // --- CSV export (DB-like format) ---
    $filename = "immunization_data.csv";
    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Expires" => "0"
    ];

    $callback = function () use ($data) {
        $file = fopen('php://output', 'w');

        if ($data->isNotEmpty()) {
            // Use model fillable as the column list
            $columns = (new \App\Models\ImmunizationManagement)->getFillable();

            // Write column headers
            fputcsv($file, $columns);

            // Write each row
            foreach ($data as $row) {
                $rowData = [];
                foreach ($columns as $col) {
                    $rowData[] = $row->$col;
                }
                fputcsv($file, $rowData);
            }
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
        // ... (keep the rest of your coordinates)
    ];

    if ($type === 'pdf') {
        // --- PDF Export (unchanged) ---
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

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
        return $pdf->download('barangay_population.pdf');
    }

    // --- CSV Export (DB-like format) ---
    $filename = "barangay_data_" . date('Y-m-d') . ".csv";
    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Expires" => "0"
    ];

    $callback = function () use ($data) {
        $file = fopen('php://output', 'w');

        if ($data->isNotEmpty()) {
            // Use DB columns (fillable fields)
            $columns = (new \App\Models\PopulationStatisticsManagement)->getFillable();

            // Write DB headers
            fputcsv($file, $columns);

            // Write rows
            foreach ($data as $row) {
                $rowData = [];
                foreach ($columns as $col) {
                    $rowData[] = $row->$col;
                }
                fputcsv($file, $rowData);
            }
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
