<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MorbidityMortalityManagement; 

class TrendsController extends Controller
{
   public function getTrendData(Request $request)
    {
        $category = $request->get('category'); // morbidity or mortality
        $caseName = $request->get('case_name');

        $query = DB::table('morbidity_mortality_management')
            ->selectRaw('DATE(date) as date, SUM(male_count + female_count) as total')
            ->whereRaw('LOWER(category) = ?', [$category]);

        if ($caseName) {
            $query->where('case_name', $caseName);
        }

        $data = $query->groupBy('date')->orderBy('date')->get();

        return response()->json([
            'success' => true,
            'labels' => $data->pluck('date'),
            'values' => $data->pluck('total'),
        ]);
    }

}
