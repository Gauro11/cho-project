<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrendsController extends Controller
{
    public function index()
    {
        // Get distinct case names from both tables
        $morbidityCases = DB::table('morbidity')->distinct()->pluck('case_name');
        $mortalityCases = DB::table('mortality')->distinct()->pluck('case_name');

        return view('staff.trends', compact('morbidityCases', 'mortalityCases'));
    }

    public function getTrendData(Request $request)
    {
        $category = $request->get('category'); // morbidity or mortality
        $caseName = $request->get('case_name');

        $table = $category === 'morbidity' ? 'morbidity' : 'mortality';

        $data = DB::table($table)
            ->selectRaw('DATE(date) as date, SUM(male_count + female_count) as total')
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
