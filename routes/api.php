<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;



// Authenticated user route
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 📌 Only use ONE version of this route
// Route::get('/trend-data/{category}', function ($category) {
//     try {
//         $subCategory = request('sub_category');

//         $historicalData = [];
//         $predictionData = [];

//         switch ($category) {
//             case 'morbidity':
//             case 'mortality':
//                 if (!$subCategory) {
//                     return response()->json([
//                         'success' => false,
//                         'message' => 'Sub-category required for morbidity/mortality'
//                     ]);
//                 }
//                 $historicalData = getMorbidityMortalityData($category, $subCategory);
//                 break;

//             case 'vital_statistics':
//                 $historicalData = getVitalStatisticsData();
//                 break;

//             case 'population_statistics':
//                 $historicalData = getPopulationStatisticsData();
//                 break;

//             case 'immunization':
//                 $historicalData = getImmunizationData();
//                 break;

//             default:
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Invalid category'
//                 ]);
//         }

//         $predictionData = generatePrediction($historicalData['values']);

//         return response()->json([
//             'success' => true,
//             'historical' => $historicalData,
//             'prediction' => $predictionData
//         ]);

//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => $e->getMessage()
//         ]);
//     }
// });


// -------------------------------------------
// 🔧 Data helper functions
// -------------------------------------------

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
        $labels[] = date('M Y', strtotime($record->date));
        $values[] = $record->population;
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
        $values[] = $record->total_live_births;
    }

    return [
        'labels' => $labels,
        'values' => $values
    ];
}

function generatePrediction($historicalValues) {
    if (count($historicalValues) < 3) {
        return null;
    }

    $n = count($historicalValues);
    $sumX = $sumY = $sumXY = $sumX2 = 0;

    for ($i = 0; $i < $n; $i++) {
        $sumX += $i;
        $sumY += $historicalValues[$i];
        $sumXY += $i * $historicalValues[$i];
        $sumX2 += $i * $i;
    }

    $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
    $intercept = ($sumY - $slope * $sumX) / $n;

    $predictionValues = [];
    for ($i = $n; $i < $n + 2; $i++) {
        $predictionValues[] = $intercept + $slope * $i;
    }

    $lastDate = new DateTime();
    $predictionLabels = [];
    for ($i = 1; $i <= 2; $i++) {
        $lastDate->add(new DateInterval('P1M'));
        $predictionLabels[] = $lastDate->format('M Y');
    }

    $trend = $slope > 0 ? 'increasing' : ($slope < 0 ? 'decreasing' : 'stable');

    return [
        'labels' => $predictionLabels,
        'values' => $predictionValues,
        'trend' => $trend
    ];
}
