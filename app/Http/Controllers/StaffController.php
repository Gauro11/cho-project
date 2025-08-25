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
    // Your existing index method for dashboard
    public function index()
    {
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;

            if ($usertype == 'user' || $usertype == 'staff') {
                $barangays = DB::table('population_statistics_management')->get();

                $morbidityCases = DB::table('morbidity_mortality_management')
                    ->where('category', 'morbidity')
                    ->get();

                $mortalityCases = DB::table('morbidity_mortality_management')
                    ->where('category', 'mortality')
                    ->get();

                $vitalStatisticsData = DB::table('vital_statistics_management')->get();

                $immunizationData = DB::table('immunization_management')->get();

                return view('staff.index', compact('morbidityCases', 'barangays', 'mortalityCases', 'vitalStatisticsData', 'immunizationData'));
            } elseif ($usertype == 'mortality and morbidity records manager') {
                $morbidityCases = DB::table('morbidity_mortality_management')
                    ->where('category', 'morbidity')
                    ->get();

                $mortalityCases = DB::table('morbidity_mortality_management')
                    ->where('category', 'mortality')
                    ->get();

                return view('morbiditymortality.index', compact('morbidityCases', 'mortalityCases'));
            } elseif ($usertype == 'vital statistics records manager') {
                $vitalStatisticsData = DB::table('vital_statistics_management')->get();

                return view('vitalstatistics.index', compact('vitalStatisticsData'));
            } else {
                return redirect()->back()->withErrors(['error' => 'User type not recognized.']);
            }
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Please log in first.']);
        }
    }

    // ADD THIS NEW METHOD FOR STAFF MANAGEMENT
    public function showStaff()
    {
        // Get all users who are staff members with pagination
        $staff = User::where('usertype', 'staff')
                    ->orWhere('usertype', 'admin') // Include admin if needed
                    ->paginate(10);

        return view('staff.management', compact('staff')); // or whatever your view file is named
    }

    // ADD THIS METHOD TO STORE NEW STAFF
    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|unique:users,staff_id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        User::create([
            'staff_id' => $request->staff_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'usertype' => 'staff',
            'password' => Hash::make('defaultpassword'), // Set a default password
        ]);

        return redirect()->back()->with('success', 'Staff added successfully!');
    }

    // ADD THIS METHOD TO UPDATE STAFF
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        $staff = User::findOrFail($id);
        $staff->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        return redirect()->back()->with('success', 'Staff updated successfully!');
    }

    // ADD THIS METHOD TO DELETE STAFF
    public function destroy($id)
    {
        $staff = User::findOrFail($id);
        $staff->delete();

        return response()->json(['success' => true]);
    }
}