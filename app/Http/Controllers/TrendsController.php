<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MorbidityMortalityManagement; 

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
            // Handle different categories
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
                ->whereNotNull('date') // Exclude null dates
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Format dates consistently
            $formattedData = $data->map(function ($item) {
                return [
                    'date' => $item->date, // Should be in YYYY-MM-DD format
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

            // Format data for prediction generation
            $formattedData = [];
            foreach ($data['labels'] as $index => $date) {
                $formattedData[] = [
                    'date' => $date,
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
        $data = DB::table('population_statistics_management')
            ->selectRaw('DATE(`date`) as date, SUM(population) as total')
            ->whereNotNull('date')
            ->where('date', '!=', '') // Exclude empty string dates
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date')->toArray(),
            'values' => $data->pluck('total')->toArray()
        ];
    }

   private function generatePrediction($historicalData)
{
    if (count($historicalData) < 2) {
        return null;
    }

    // Extract values
    $values = array_column($historicalData, 'total');
    $n = count($values);

    // X values = 1..n (time steps)
    $x = range(1, $n);
    $y = $values;

    // Compute sums for regression
    $sumX = array_sum($x);
    $sumY = array_sum($y);
    $sumXY = 0;
    $sumXX = 0;

    for ($i = 0; $i < $n; $i++) {
        $sumXY += $x[$i] * $y[$i];
        $sumXX += $x[$i] * $x[$i];
    }

    // Calculate slope (m) and intercept (b)
    $denominator = ($n * $sumXX - $sumX * $sumX);
    if ($denominator == 0) {
        return null; // avoid divide by zero
    }

    $m = ($n * $sumXY - $sumX * $sumY) / $denominator;
    $b = ($sumY - $m * $sumX) / $n;

    // Last known date
    $lastDate = new \DateTime(end($historicalData)['date']);

    // Predict next 2 months
    $predictions = [];
    $predictionLabels = [];

    for ($i = 1; $i <= 2; $i++) {
        $nextDate = clone $lastDate;
        $nextDate->add(new \DateInterval("P{$i}M"));

        // Regression predicts for x = n + i
        $predictedValue = $m * ($n + $i) + $b;

        $predictionLabels[] = $nextDate->format('Y-m-d');
        $predictions[] = max(0, round($predictedValue));
    }

    return [
        'labels' => $predictionLabels,
        'values' => $predictions,
        'trend' => $m > 0 ? 'increasing' : ($m < 0 ? 'decreasing' : 'stable')
    ];
}

}