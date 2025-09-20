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

    // Represent x as time steps (1, 2, ..., n)
    $x = range(1, $n);
    $y = $values;

    // Compute means
    $meanX = array_sum($x) / $n;
    $meanY = array_sum($y) / $n;

    // Compute slope (m) and intercept (b)
    $num = 0;
    $den = 0;
    for ($i = 0; $i < $n; $i++) {
        $num += ($x[$i] - $meanX) * ($y[$i] - $meanY);
        $den += ($x[$i] - $meanX) ** 2;
    }
    $m = $den == 0 ? 0 : $num / $den; // slope
    $b = $meanY - $m * $meanX;        // intercept

    // Last date
    $lastDate = new \DateTime(end($historicalData)['date']);

    $predictions = [];
    $predictionLabels = [];

    for ($i = 1; $i <= 2; $i++) {
        $nextDate = clone $lastDate;
        $nextDate->add(new \DateInterval("P{$i}M"));

        $xNext = $n + $i; // next time step
        $yNext = round($m * $xNext + $b);

        $predictionLabels[] = $nextDate->format('Y-m-d');
        $predictions[] = max(0, $yNext);
    }

    return [
        'labels' => $predictionLabels,
        'values' => $predictions,
        'trend' => $m > 0 ? 'increasing' : ($m < 0 ? 'decreasing' : 'stable')
    ];
}

}