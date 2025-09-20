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
            // Replace this with your actual population data logic
            // For now, I'll show a sample structure
            $data = $this->getPopulationStatisticsData();

            return response()->json([
                'success' => true,
                'historical' => $data,
                'prediction' => null
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

        // Simple linear regression for next 2 months
        $lastValue = end($historicalData)['total'];
        $secondLastValue = prev($historicalData)['total'];
        $trend = $lastValue - $secondLastValue;

        $lastDate = new \DateTime(end($historicalData)['date']);
        
        $predictions = [];
        for ($i = 1; $i <= 2; $i++) {
            $nextDate = clone $lastDate;
            $nextDate->add(new \DateInterval("P{$i}M"));
            $predictions[] = max(0, $lastValue + ($trend * $i));
        }

        return [
            'labels' => [
                $lastDate->add(new \DateInterval('P1M'))->format('Y-m-d'),
                $lastDate->add(new \DateInterval('P1M'))->format('Y-m-d')
            ],
            'values' => $predictions,
            'trend' => $trend > 0 ? 'increasing' : ($trend < 0 ? 'decreasing' : 'stable')
        ];
    }
}