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

    $values = array_column($historicalData, 'total');
    $n = count($values);

    // Represent x as time steps (1, 2, 3, ..., n)
    $x = range(1, $n);
    $y = $values;

    // Compute means
    $meanX = array_sum($x) / $n;
    $meanY = array_sum($y) / $n;

    // Compute slope (m) and intercept (b) for y = m*x + b
    $numerator = 0;
    $denominator = 0;
    for ($i = 0; $i < $n; $i++) {
        $numerator += ($x[$i] - $meanX) * ($y[$i] - $meanY);
        $denominator += pow($x[$i] - $meanX, 2);
    }

    $m = $denominator ? $numerator / $denominator : 0; // slope
    $b = $meanY - ($m * $meanX); // intercept

    // Last date
    $lastDate = new \DateTime(end($historicalData)['date']);

    $predictionLabels = [];
    $predictionValues = [];

    // Predict for next 2 months
    for ($i = 1; $i <= 2; $i++) {
        $nextX = $n + $i;
        $predictedY = $m * $nextX + $b;

        $nextDate = clone $lastDate;
        $nextDate->add(new \DateInterval("P{$i}M"));

        $predictionLabels[] = $nextDate->format('Y-m-d');
        $predictionValues[] = max(0, round($predictedY));
    }

    // Regression values for all points (historical + prediction)
    $regressionValues = [];
    for ($i = 1; $i <= $n + 2; $i++) {
        $regressionValues[] = round($m * $i + $b);
    }

    return [
        'prediction' => [
            'labels' => $predictionLabels,
            'values' => $predictionValues,
            'trend' => $m > 0 ? 'increasing' : ($m < 0 ? 'decreasing' : 'stable'),
            'slope' => $m,
            'intercept' => $b
        ],
        'regression' => [
            'values' => $regressionValues
        ]
    ];
}


}