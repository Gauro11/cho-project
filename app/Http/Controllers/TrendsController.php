<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MorbidityMortalityManagement; 

class TrendsController extends Controller
{
    public function index()
    {
        $morbidityCases = DB::table('morbidity_mortality_management')
            ->where('category', 'morbidity')
            ->distinct()
            ->pluck('case_name')
            ->toArray();

        $mortalityCases = DB::table('morbidity_mortality_management')
            ->where('category', 'mortality')
            ->distinct()
            ->pluck('case_name')
            ->toArray();

        return view('staff.trends', compact('morbidityCases', 'mortalityCases'));
    }

    public function getTrendData(Request $request, $category)
    {
        try {
            // Get the sub_category (case_name) from request
            $subCategory = $request->get('sub_category');
            
            // Base query
            $query = DB::table('morbidity_mortality_management')
                ->selectRaw('DATE_FORMAT(`date`, "%Y-%m") as date, SUM(male_count + female_count) as total')
                ->where('category', $category)
                ->groupBy(DB::raw('DATE_FORMAT(`date`, "%Y-%m")'))
                ->orderBy('date');

            // Add case_name filter if provided
            if ($subCategory) {
                $query->where('case_name', $subCategory);
            }

            $data = $query->get();

            // Prepare historical data
            $historical = [
                'labels' => $data->pluck('date')->toArray(),
                'values' => $data->pluck('total')->map(function($value) {
                    return (int) $value;
                })->toArray()
            ];

            // Simple prediction logic (you can enhance this)
            $prediction = null;
            if (count($historical['values']) >= 2) {
                $lastValue = end($historical['values']);
                $secondLastValue = $historical['values'][count($historical['values']) - 2];
                $trend = $lastValue > $secondLastValue ? 'increasing' : 'decreasing';
                
                // Generate next 2 months
                $lastDate = end($historical['labels']);
                $nextMonth1 = date('Y-m', strtotime($lastDate . '-01 +1 month'));
                $nextMonth2 = date('Y-m', strtotime($lastDate . '-01 +2 month'));
                
                // Simple prediction calculation
                $change = $lastValue - $secondLastValue;
                $predictedValue1 = max(0, $lastValue + $change);
                $predictedValue2 = max(0, $predictedValue1 + $change);
                
                $prediction = [
                    'labels' => [$nextMonth1, $nextMonth2],
                    'values' => [(int) $predictedValue1, (int) $predictedValue2],
                    'trend' => $trend
                ];
            }

            return response()->json([
                'success' => true,
                'historical' => $historical,
                'prediction' => $prediction
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching data: ' . $e->getMessage()
            ], 500);
        }
    }
}