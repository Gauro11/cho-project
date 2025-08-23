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
    $caseName = $request->query('sub_category');

    $data = DB::table('morbidity_mortality_management')
        ->selectRaw('`date` as date, SUM(male_count + female_count) as total')
        ->where('category', $category)
        ->when($caseName, function ($query) use ($caseName) {
            return $query->where('case_name', $caseName);
        })
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    return response()->json([
        'success' => true,
        'historical' => [
            'labels' => $data->pluck('date'),
            'values' => $data->pluck('total'),
        ],
        'prediction' => null // you can add prediction logic here later
    ]);
}


}
