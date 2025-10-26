<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PopulationStatisticsManagement;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PopulationImport;
use App\Exports\PopulationTemplateExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PopulationController extends Controller
{
    /**
     * Show population records (paginated) for staff
     */
    public function show_population()
    {
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('login')->withErrors(['error' => 'Please log in first.']);
        }

        $user = Auth::guard('staff')->user();
        $data = PopulationStatisticsManagement::paginate(10);

        return view('populationstatistics.population', compact('data', 'user'));
    }

    /**
     * Store a new population record
     */
    public function store_population(Request $request)
{
    try {
        $validated = $request->validate([
            'location' => 'required|string|max:255',
            'year_month' => 'required|string',
            'population' => 'required|integer|min:0',
        ]);

        $population = PopulationStatisticsManagement::create([
            'location' => $validated['location'],
            'year_month' => $validated['year_month'] ?? null,
            'population' => $validated['population'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Population data added successfully!',
            'data' => ['id' => $population->id],
        ]);

    } catch (\Exception $e) {
        // Return actual exception for debugging
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
}


    /**
     * Update an existing population recordDD
     */
    public function update_population(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|integer|exists:population_statistics_management,id',
                'location' => 'required|string|max:255',
                'year_month' => 'required|string|regex:/^(19|20)\d{2}-(0[1-9]|1[0-2])$/',
                'population' => 'required|integer|min:0',
            ]);

            $population = PopulationStatisticsManagement::findOrFail($validated['id']);
            $population->update($request->only(['location', 'year_month', 'population']));

            return response()->json([
                'success' => true,
                'message' => 'Population data updated successfully!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update population data: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a single population record
     */
    public function delete_population($id)
    {
        try {
            $population = PopulationStatisticsManagement::findOrFail($id);
            $population->delete();

            return response()->json([
                'success' => true,
                'message' => 'Population record deleted successfully!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete population data: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete multiple selected population records
     */
    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids');

        if (empty($ids) || !is_array($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No records selected for deletion',
            ], 400);
        }

        try {
            $deletedCount = PopulationStatisticsManagement::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => "$deletedCount population records deleted successfully!",
                'deleted_count' => $deletedCount,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete selected records: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete all population records
     */
    public function deleteAll()
    {
        try {
            $count = PopulationStatisticsManagement::count();
            PopulationStatisticsManagement::truncate();

            return response()->json([
                'success' => true,
                'message' => "All $count population records deleted successfully",
                'deleted_count' => $count,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete all records: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get population data for barangays
     */
    public function getBarangays()
    {
        try {
            $data = PopulationStatisticsManagement::select('location', 'population', 'year_month')
                ->orderBy('location', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'barangays' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching barangay population data: '.$e->getMessage()
            ], 500);
        }
    }

    /**
     * Download population template
     */
    public function downloadTemplate()
    {
        return Excel::download(new PopulationTemplateExport, 'population_template.xlsx');
    }

    /**
     * Import population data from Excel/CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new PopulationImport, $request->file('file'));
            return back()->with('success', 'Population data imported successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Import failed: '.$e->getMessage()]);
        }
    }

    /**
     * Get Dagupan city population from PSGC API
     */
    public function getDagupanPopulation()
    {
        $cityCode = "0105518000";

        try {
            $response = Http::timeout(10)->get("https://psgc.cloud/api/cities/{$cityCode}");
            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'status' => $response->status(),
                    'message' => 'Failed to fetch Dagupan PSGC data',
                ], $response->status());
            }

            $data = $response->json();

            // Hardcoded population (PSGC API doesn't provide)
            $population = 174302;
            $year = 2020;

            return response()->json([
                'success' => true,
                'city' => $data['name'] ?? 'Dagupan City',
                'code' => $data['code'] ?? $cityCode,
                'type' => $data['cityClass'] ?? $data['type'] ?? null,
                'zip_code' => $data['zipCode'] ?? $data['zip_code'] ?? null,
                'region' => $data['region']['name'] ?? null,
                'province' => $data['province']['name'] ?? null,
                'population' => $population,
                'year' => $year
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch population: '.$e->getMessage()
            ], 500);
        }
    }
}
