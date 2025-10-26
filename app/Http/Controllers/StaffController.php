<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use App\Models\Diseases;
use App\Models\Category;
use App\Models\Year;

use App\Models\Data;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class StaffController extends Controller
{
   
    
    
public function index()
{
    if (Auth::guard('staff')->check()) {
        $user = Auth::guard('staff')->user();
        $usertype = $user->usertype;

        if ($usertype == 'user' || $usertype == 'staff') {
            $barangays = DB::table('population_statistics_management')
                ->orderBy('year', 'asc')
                ->get();

            $totalPopulation = DB::table('population_statistics_management')->sum('population');

            $morbidityCases = DB::table('morbidity_mortality_management')
                ->where('category', 'morbidity')
                ->get();

            $mortalityCases = DB::table('morbidity_mortality_management')
                ->where('category', 'mortality')
                ->get();

            $vitalStatisticsData = DB::table('vital_statistics_management')->get();

            $immunizationData = DB::table('immunization_management')->get();

            return view('staff.index', compact(
                'morbidityCases', 
                'barangays', 
                'mortalityCases', 
                'vitalStatisticsData', 
                'immunizationData', 
                'totalPopulation'
            ));
        }

        // Other user types...
        return redirect()->back()->withErrors(['error' => 'User type not recognized.']);

    } else {
        return redirect()->route('login')->withErrors(['error' => 'Please log in first.']);
    }
}


    



}

