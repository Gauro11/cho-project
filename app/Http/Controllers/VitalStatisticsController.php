<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VitalStatisticsManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // ADD THIS LINE
use App\Models\VitalStatistic;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VitalStatisticsImport;
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

        $data = VitalStatisticsManagement::findOrFail($request->id);
        $data->year = $request->year;
        $data->total_live_births = $request->total_live_births;
        $data->total_deaths = $request->total_deaths;
        $data->infant_deaths = $request->infant_deaths;
        $data->maternal_deaths = $request->maternal_deaths;
        $data->save();

        return response()->json(['success' => true]);
    }

    public function store_vitalstatiscs(Request $request)
    {
        $request->validate([
            'year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'total_live_births' => 'required|integer|min:0',
            'total_deaths' => 'required|integer|min:0',
            'infant_deaths' => 'required|integer|min:0',
            'maternal_deaths' => 'required|integer|min:0',
        ]);

        $exists = VitalStatisticsManagement::where('year', $request->year)->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'A record for this year already exists.',
            ]);
        }

        VitalStatisticsManagement::create([
            'year' => $request->year,
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

            // Paginated data for the table
            $data = VitalStatisticsManagement::orderBy('year', 'asc')->paginate(10);

            // Get total population from population_statistics_management table
            // Sum all population values from all locations
            $populationData = DB::table('population_statistics_management')
                ->sum('population');

            // Alternative: Get latest population data only
            // $populationData = DB::table('population_statistics_management')
            //     ->orderBy('year_month', 'desc')
            //     ->sum('population');

            // Fallback if no data
            if (!$populationData || $populationData == 0) {
                $populationData = 100000; // Default fallback
            }

            // Prepare data for charts - Group by year and sum values
            $yearlyData = VitalStatisticsManagement::orderBy('year', 'asc')
                ->get()
                ->groupBy('year')
                ->map(function ($rows) use ($populationData) {
                    $births = $rows->sum('total_live_births');
                    $deaths = $rows->sum('total_deaths');
                    $infantDeaths = $rows->sum('infant_deaths');
                    $maternalDeaths = $rows->sum('maternal_deaths');
                    
                    return [
                        'births' => $births,
                        'deaths' => $deaths,
                        'infant_deaths' => $infantDeaths,
                        'maternal_deaths' => $maternalDeaths,
                        'nir' => $populationData > 0 ? (($births - $deaths) / $populationData) * 1000 : 0
                    ];
                });

            return view('vitalstatistics.vitalstatistics', compact(
                'data',
                'user',
                'yearlyData',
                'populationData'
            ));
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

    public function deleteSelected(Request $request)
    {
        try {
            $ids = $request->input('ids');

            if (empty($ids) || !is_array($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No records selected for deletion'
                ], 400);
            }

            $deletedCount = VitalStatisticsManagement::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => "Selected records deleted successfully",
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