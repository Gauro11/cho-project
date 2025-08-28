<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VitalStatisticsManagement;
use Illuminate\Support\Facades\Auth;
use App\Models\VitalStatistic; // your model
use Maatwebsite\Excel\Facades\Excel; // if you're using Laravel Excel
use App\Imports\VitalStatisticsImport; // your import class
use App\Exports\VitalStatisticTemplateExport;



class VitalStatisticsController extends Controller
{

    public function delete_vitalstatistics($id)
    {
        $data = VitalStatisticsManagement::findOrFail($id);
        $data->delete();
    
        return response()->json(['success' => true]);
    }

    public function update_vitalstatiscs(Request $request)
{
    $request->validate([
        'id' => 'required|exists:vital_statistics_management,id',
        'year' => 'required|string',
        
        'total_live_births' => 'required|numeric',
        'total_deaths' => 'required|numeric',
        'infant_deaths' => 'required|numeric',
        'maternal_deaths' => 'required|numeric',
    ]);
    
    try {
        $data = VitalStatisticsManagement::find($request->id);

        $data->year = $request->year;
       
        $data->total_live_births = $request->total_live_births;
        $data->total_deaths = $request->total_deaths;
        $data->infant_deaths = $request->infant_deaths;
        $data->maternal_deaths = $request->maternal_deaths;
        $data->save();

        return response()->json(['success' => true, 'message' => 'Data updated successfully.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}
public function store_vitalstatiscs(Request $request)
{
    $request->validate([
        'month_year' => 'required|string',
       
        'total_live_births' => 'required|integer|min:0',
        'total_deaths' => 'required|integer|min:0',
        'infant_deaths' => 'required|integer|min:0',
        'maternal_deaths' => 'required|integer|min:0',
    ]);

    // Check if year already exists
    $exists = VitalStatisticsManagement::where('year', $request->month_year)->exists();

    if ($exists) {
        return response()->json([
            'success' => false,
            'message' => 'A record for this year already exists.',
        ]);
    }

    VitalStatisticsManagement::create([
        'year' => $request->month_year,
       
        'total_live_births' => $request->total_live_births,
        'total_deaths' => $request->total_deaths,
        'infant_deaths' => $request->infant_deaths,
        'maternal_deaths' => $request->maternal_deaths,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Vital statistics record added successfully.',
    ]);
}





   public function show_vital_statistics()
{
    if (Auth::guard('staff')->check()) {
        $user = Auth::guard('staff')->user();
        $data = VitalStatisticsManagement::paginate(10);
        return view('vitalstatistics.vitalstatistics', compact('data', 'user'));
    } else {
        return redirect()->route('login')->withErrors(['error' => 'Please log in first.']);
    }
}

      public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    Excel::import(new VitalStatisticsImport, $request->file('file'));

    return back()->with('success', 'Population data imported successfully.');
}

 public function vitalstatisticTemplate()
    {
        return Excel::download(new VitalStatisticTemplateExport, 'vital_statistics_template.xlsx');
    }

public function deleteAll()
{
    try {
        $deletedCount = VitalStatisticsManagement::count(); // Get count before deletion
        VitalStatisticsManagement::truncate(); // Deletes all records
        
        return response()->json([
            'success' => true,
            'message' => 'All records deleted successfully',
            'deleted_count' => $deletedCount
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete records: ' . $e->getMessage()
        ], 500);
    }
}
    

}
