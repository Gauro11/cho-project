<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PopulationStatisticsManagement;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PopulationImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Exports\PopulationTemplateExport;



class PopulationController extends Controller
{

    public function delete_population($id)
    {
        $data = PopulationStatisticsManagement::findOrFail($id);
        $data->delete();
    
        return response()->json(['success' => true]);
    }

    public function update_population(Request $request)
    {
        // Validate input data
        $request->validate([
            'location' => 'required|string',
            'year' => 'required|integer|min:1900|max:2099',
            'total_population' => 'required|integer|min:1', // Change 'population' to 'total_population'
        ]);
    
        // Find the record by ID
        try {
            $data = PopulationStatisticsManagement::find($request->id);
    
            $data->location = $request->location;
            $data ->year = $request->year; // Change to match the form field
            $data->population = $request->total_population; // Change to match the form field
            $data->save();
    
            return response()->json(['success' => true, 'message' => 'Data updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }    
       
    }
    
   public function store_population(Request $request)
{
    // Validate the request data
    $request->validate([
        'location' => 'required|string|max:255',
        'year' => 'required|integer|min:1900|max:2099',
        'population' => 'required|integer|min:0',
    ]);

    // Check for duplicate location
    $exists = PopulationStatisticsManagement::where('location', $request->location)->exists();

    if ($exists) {
        return response()->json([
            'success' => false,
            'message' => 'Population data for this location already exists!',
        ]);
    }

    // Store the data in the database
    PopulationStatisticsManagement::create([
        'location' => $request->location,
        'year' => $request->year,
        'population' => $request->population,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Population data added successfully!',
    ]);
}

public function show_population()
{
    try {
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('login')->withErrors(['error' => 'Please log in first.']);
        }

        $user = Auth::guard('staff')->user();
        $data = PopulationStatisticsManagement::paginate(10);

        return view('populationstatistics.population', compact('data', 'user'));

    } catch (\Exception $e) {
        dd($e->getMessage(), $e->getTraceAsString());
    }
}




public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    Excel::import(new PopulationImport, $request->file('file'));

    return back()->with('success', 'Population data imported successfully.');
}

 public function getBarangays()
    {
        try {
            $data = PopulationStatisticsManagement::select('location', 'population', 'date')
                ->orderBy('location', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'barangays' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching barangay population data',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


public function downloadTemplate()
{
    return Excel::download(new PopulationTemplateExport, 'population_template.xlsx');
}








public function getDagupanPopulation()
{
    $cityCode = "0105518000"; // Correct PSGC code for Dagupan

    // PSGC metadata endpoint
    $psgcUrl = "https://psgc.cloud/api/cities/{$cityCode}";

    try {
        $response = Http::timeout(10)->get($psgcUrl);

        if (!$response->successful()) {
            return response()->json([
                'success' => 0,
                'status'  => $response->status(),
                'message' => 'Failed to fetch Dagupan PSGC data',
            ], $response->status());
        }

        $data = $response->json();

        // Hardcode population since PSGC Cloud doesn't provide it
        $population = 174302;
        $year       = 2020;

        return response()->json([
            'success'    => 1,
            'city'       => $data['name'] ?? 'Dagupan City',
            'code'       => $data['code'] ?? $cityCode,
            'type'       => $data['cityClass'] ?? $data['type'] ?? null,
            'zip_code'   => $data['zipCode'] ?? $data['zip_code'] ?? null,
            'region'     => $data['region']['name'] ?? null,
            'province'   => $data['province']['name'] ?? null,
            'population' => $population,
            'year'       => $year
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => 0,
            'error'   => $e->getMessage(),
            'message' => 'Request failed',
        ], 500);
    }
}

public function deleteAll()
{
    try {
        $deletedCount = PopulationStatisticsManagement::count(); // Get count before deletion
        PopulationStatisticsManagement::truncate(); // Deletes all records
        
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
