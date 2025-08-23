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
     public function index(Request $request)
    {
        $search = $request->get('search');
        
        $staff = User::when($search, function($query) use ($search) {
            $query->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('staff_id', 'LIKE', "%{$search}%")
                  ->orWhere('usertype', 'LIKE', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10); // 10 items per page
        
        return view('staff.index', compact('staff'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required|unique:users,staff_id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'staff_id' => $request->staff_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'usertype' => 'staff', // Default usertype
            'email' => $request->staff_id . '@company.com', // Generate email if needed
            'password' => bcrypt('default123'), // Default password
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff member added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $staff = User::findOrFail($id);
        $staff->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully!');
    }

    public function destroy($id)
    {
        try {
            $staff = User::findOrFail($id);
            $staff->delete();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete staff member.']);
        }
    }
// public function index()
// {
//     if (Auth::check()) {
//         $usertype = Auth::user()->usertype;

//         if ($usertype == 'user' || $usertype == 'staff') {
//             $barangays = DB::table('population_statistics_management')->get();

//             $morbidityCases = DB::table('morbidity_mortality_management')
//                 ->where('category', 'morbidity')
//                 ->get();

//             $mortalityCases = DB::table('morbidity_mortality_management')
//                 ->where('category', 'mortality')
//                 ->get();

//             $vitalStatisticsData = DB::table('vital_statistics_management')->get();

//             $immunizationData = DB::table('immunization_management')->get();

//             return view('staff.index', compact('morbidityCases', 'barangays', 'mortalityCases', 'vitalStatisticsData', 'immunizationData'));
//         } elseif ($usertype == 'mortality and morbidity records manager') {
//             $morbidityCases = DB::table('morbidity_mortality_management')
//                 ->where('category', 'morbidity')
//                 ->get();

//             $mortalityCases = DB::table('morbidity_mortality_management')
//                 ->where('category', 'mortality')
//                 ->get();

//             return view('morbiditymortality.index', compact('morbidityCases', 'mortalityCases'));
//         } elseif ($usertype == 'vital statistics records manager') {
//             $vitalStatisticsData = DB::table('vital_statistics_management')->get();

//             return view('vitalstatistics.index', compact('vitalStatisticsData'));
//         } else {
//             return redirect()->back()->withErrors(['error' => 'User type not recognized.']);
//         }
//     } else {
//         return redirect()->route('login')->withErrors(['error' => 'Please log in first.']);
//     }
// }


    



}

