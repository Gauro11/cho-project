<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrendsController extends Controller
{
    public function index()
    {
        // Fetch distinct cases per category from your single table
        $morbidityCases = DB::table('morbidity_mortality_management')
            ->where('category', 'morbidity')
            ->distinct()
            ->pluck('case_name');

        $mortalityCases = DB::table('morbidity_mortality_management')
            ->where('category', 'mortality')
            ->distinct()
            ->pluck('case_name');

        return view('staff.trends', compact('morbidityCases', 'mortalityCases'));
    }

    public function getTrendData(Request $request)
    {
        $category = $request->get('category'); // morbidity or mortality
        $caseName = $request->get('case_name');

        $data = DB::table('morbidity_mortality_management')
            ->selectRaw('DATE(date) as date, SUM(male_count + female_count) as total')
            ->where('category', $category)
            ->where('case_name', $caseName)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'labels' => $data->pluck('date'),
            'values' => $data->pluck('total'),
        ]);
    }
}
