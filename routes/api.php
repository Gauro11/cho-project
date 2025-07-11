<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\DB;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/trend-data/{category}', [AdminController::class, 'fetchTrendData']);


// routes/api.php
Route::get('/trend-data/{category}', function ($category) {
    try {
        $subCategory = request('sub_category');
        
        // Get historical data based on category
        $historicalData = [];
        $predictionData = [];
        
        switch ($category) {
            case 'morbidity':
            case 'mortality':
                if (!$subCategory) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Sub-category required for morbidity/mortality'
                    ]);
                }
                
                $historicalData = getMorbidityMortalityData($category, $subCategory);
                break;
                
            case 'vital_statistics':
                $historicalData = getVitalStatisticsData();
                break;
                
            case 'population_statistics':
                $historicalData = getPopulationStatisticsData();
                break;
                
            case 'immunization':
                $historicalData = getImmunizationData();
                break;
                
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid category'
                ]);
        }
        
        // Generate prediction (2 months ahead)
        $predictionData = generatePrediction($historicalData['values']);
        
        return response()->json([
            'success' => true,
            'historical' => $historicalData,
            'prediction' => $predictionData
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
});

// Helper functions to get data from database
function getMorbidityMortalityData($category, $caseName) {
    $data = DB::table('morbidity_mortality_management')
              ->where('category', $category)
              ->where('case_name', $caseName)
              ->orderBy('date')
              ->get();
              
    $labels = [];
    $values = [];
    
    foreach ($data as $record) {
        $labels[] = date('M Y', strtotime($record->date));
        $values[] = $record->male_count + $record->female_count;
    }
    
    return [
        'labels' => $labels,
        'values' => $values
    ];
}

function getPopulationStatisticsData() {
    $data = DB::table('population_statistics_management')
              ->orderBy('date')
              ->get();

    $labels = [];
    $values = [];

    foreach ($data as $record) {
        $labels[] = date('M Y', strtotime($record->date)); // Format date as "Jan 2024"
        $values[] = $record->population; // Get the population value
    }

    return [
        'labels' => $labels,
        'values' => $values
    ];
}


function getImmunizationData() {
    $data = DB::table('immunization_management')
              ->orderBy('date')
              ->get();

    $labels = [];
    $values = [];

    foreach ($data as $record) {
        $labels[] = date('M Y', strtotime($record->date));
        $values[] = $record->male_vaccinated + $record->female_vaccinated;
    }

    return [
        'labels' => $labels,
        'values' => $values
    ];
}


function getVitalStatisticsData() {
    $data = DB::table('vital_statistics_management')
              ->orderBy('year')
              ->get();
              
    $labels = [];
    $values = [];
    
    foreach ($data as $record) {
        $labels[] = $record->year;
        $values[] = $record->total_live_births; // Or any other metric you want to track
    }
    
    return [
        'labels' => $labels,
        'values' => $values
    ];
}

// Similar functions for other categories...

// Prediction algorithm (simple linear regression)
function generatePrediction($historicalValues) {
    if (count($historicalValues) < 3) {
        return null; // Not enough data for prediction
    }
    
    $n = count($historicalValues);
    $sumX = 0;
    $sumY = 0;
    $sumXY = 0;
    $sumX2 = 0;
    
    // Calculate regression coefficients
    for ($i = 0; $i < $n; $i++) {
        $sumX += $i;
        $sumY += $historicalValues[$i];
        $sumXY += $i * $historicalValues[$i];
        $sumX2 += $i * $i;
    }
    
    $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
    $intercept = ($sumY - $slope * $sumX) / $n;
    
    // Generate next 2 months prediction
    $predictionValues = [];
    for ($i = $n; $i < $n + 2; $i++) {
        $predictionValues[] = $intercept + $slope * $i;
    }
    
    // Generate labels for next 2 months
    $lastDate = new DateTime(); // Adjust this based on your actual last date
    $predictionLabels = [];
    for ($i = 1; $i <= 2; $i++) {
        $lastDate->add(new DateInterval('P1M'));
        $predictionLabels[] = $lastDate->format('M Y');
    }
    
    // Determine trend
    $trend = $slope > 0 ? 'increasing' : ($slope < 0 ? 'decreasing' : 'stable');
    
    return [
        'labels' => $predictionLabels,
        'values' => $predictionValues,
        'trend' => $trend
    ];
}
