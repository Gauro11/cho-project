<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MorbidityMortalityManagement; 
use App\Models\PopulationStatisticsManagement; 

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

public function getPopulationData()
{
    $filter = $request->get('filter', 'monthly');
    $date = $request->get('date');

    $query = PopulationStatisticsManagement::select('date', 'population')
        ->orderBy('date', 'asc');

    if ($filter === 'specific' && $date) {
        $query->whereDate('date', $date);
    }

    $records = $query->get();

    $labels = [];
    $values = [];

    if ($filter === 'monthly') {
        $grouped = $records->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->date)->format('M Y');
        });
    } elseif ($filter === 'quarterly') {
        $grouped = $records->groupBy(function($item) {
            $quarter = ceil(\Carbon\Carbon::parse($item->date)->month / 3);
            return 'Q'.$quarter.' '.\Carbon\Carbon::parse($item->date)->year;
        });
    } elseif ($filter === 'yearly') {
        $grouped = $records->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->date)->year;
        });
    } elseif ($filter === 'specific' && $date) {
        $grouped = $records->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->date)->toFormattedDateString();
        });
    }

    foreach ($grouped as $label => $items) {
        $labels[] = $label;
        $values[] = $items->avg('population'); // or sum, depends on your requirement
    }

    return response()->json([
        'success' => true,
        'historical' => [
            'labels' => $labels,
            'values' => $values,
        ],
        // You can keep prediction logic here if needed
    ]);
}



}
