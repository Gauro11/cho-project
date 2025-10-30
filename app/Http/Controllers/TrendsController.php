<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MorbidityMortalityManagement; 
use Carbon\Carbon;

class TrendsController extends Controller
{
    public function getCaseTypes($category)
    {
        $cases = DB::table('morbidity_mortality_management')
            ->whereRaw('LOWER(category) = ?', [strtolower($category)])
            ->distinct()
            ->pluck('case_name');

        return response()->json([
            'success' => true,
            'cases' => $cases
        ]);
    }

    public function getTrendData(Request $request, $category)
    {
        try {
            // Handle Population Statistics separately
            if ($category === 'population_statistics') {
                return $this->getPopulationData();
            }

            // Handle morbidity/mortality
            $caseName = $request->query('sub_category');

            $data = DB::table('morbidity_mortality_management')
                ->selectRaw('DATE(`date`) as date, SUM(male_count + female_count) as total')
                ->whereRaw('LOWER(category) = ?', [strtolower($category)])
                ->when($caseName, function ($query) use ($caseName) {
                    return $query->where('case_name', $caseName);
                })
                ->whereNotNull('date')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $formattedData = $data->map(function ($item) {
                return [
                    'date' => $item->date, // YYYY-MM-DD
                    'total' => (int) $item->total
                ];
            });

            return response()->json([
                'success' => true,
                'historical' => [
                    'labels' => $formattedData->pluck('date')->toArray(),
                    'values' => $formattedData->pluck('total')->toArray(),
                ],
                'prediction' => $this->generatePrediction($formattedData->toArray())
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getPopulationData()
    {
        try {
            $data = $this->getPopulationStatisticsData();

            $formattedData = [];
            foreach ($data['labels'] as $index => $yearMonth) {
                $formattedData[] = [
                    'date' => $yearMonth, // keep "year_month" as date
                    'total' => $data['values'][$index]
                ];
            }

            return response()->json([
                'success' => true,
                'historical' => $data,
                'prediction' => $this->generatePrediction($formattedData)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

private function getPopulationStatisticsData()
{
    // First, get all data
    $rawData = DB::table('population_statistics_management')
        ->select('year_month', 'population')
        ->whereNotNull('year_month')
        ->where('year_month', '!=', '')
        ->get();

    // Group by year in PHP (more flexible)
    $grouped = [];
    
    foreach ($rawData as $row) {
        // Extract year from year_month (handles "2024-01", "2024", etc.)
        $yearMonth = $row->year_month;
        
        // Extract first 4 digits as year
        if (preg_match('/^(\d{4})/', $yearMonth, $matches)) {
            $year = $matches[1];
            
            if (!isset($grouped[$year])) {
                $grouped[$year] = 0;
            }
            
            $grouped[$year] += (int)$row->population;
        }
    }

    // Sort by year
    ksort($grouped);

    $labels = array_keys($grouped);
    $values = array_values($grouped);

    // Log for debugging
    \Log::info('Population Statistics Data:', [
        'labels' => $labels,
        'values' => $values,
        'sample_year_month' => $rawData->pluck('year_month')->take(5)->toArray()
    ]);

    return [
        'labels' => $labels,
        'values' => $values
    ];
}




   private function generatePrediction($historicalData)
{
    if (count($historicalData) < 2) {
        return null;
    }

    $values = array_column($historicalData, 'total');
    $n = count($values);

    $x = range(1, $n);
    $y = $values;

    $meanX = array_sum($x) / $n;
    $meanY = array_sum($y) / $n;

    $num = 0;
    $den = 0;
    for ($i = 0; $i < $n; $i++) {
        $num += ($x[$i] - $meanX) * ($y[$i] - $meanY);
        $den += ($x[$i] - $meanX) ** 2;
    }
    $m = $den == 0 ? 0 : $num / $den; // slope
    $b = $meanY - $m * $meanX;        // intercept

    // Check if date is year format (YYYY) or year-month (YYYY-MM)
    $lastDateStr = end($historicalData)['date'];
    
    // If it's just a year (4 digits)
    if (preg_match('/^\d{4}$/', $lastDateStr)) {
        $lastYear = (int)$lastDateStr;
        
        $predictions = [];
        $predictionLabels = [];

        for ($i = 1; $i <= 2; $i++) {
            $nextYear = $lastYear + $i;
            $xNext = $n + $i;
            $yNext = round($m * $xNext + $b);

            $predictionLabels[] = (string)$nextYear;
            $predictions[] = max(0, $yNext);
        }
    } else {
        // Original month-based logic
        $lastDate = new \DateTime($lastDateStr . '-01');
        
        $predictions = [];
        $predictionLabels = [];

        for ($i = 1; $i <= 2; $i++) {
            $nextDate = clone $lastDate;
            $nextDate->add(new \DateInterval("P{$i}M"));

            $xNext = $n + $i;
            $yNext = round($m * $xNext + $b);

            $predictionLabels[] = $nextDate->format('Y-m');
            $predictions[] = max(0, $yNext);
        }
    }

    return [
        'labels' => $predictionLabels,
        'values' => $predictions,
        'trend' => $m > 0 ? 'increasing' : ($m < 0 ? 'decreasing' : 'stable'),
        'formula' => "y = " . round($m, 2) . "x + " . round($b, 2)
    ];
}
}
