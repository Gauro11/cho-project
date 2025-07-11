<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VitalStatisticsManagement;


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
        'total_population' => 'required|numeric',
        'total_live_births' => 'required|numeric',
        'total_deaths' => 'required|numeric',
        'infant_deaths' => 'required|numeric',
        'maternal_deaths' => 'required|numeric',
    ]);
    
    try {
        $data = VitalStatisticsManagement::find($request->id);

        $data->year = $request->year;
        $data->total_population = $request->total_population;
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
    // Validate the incoming request
    $request->validate([
        'month_year' => 'required|string',
        'total_population' => 'required|integer|min:0',
        'total_live_births' => 'required|integer|min:0',
        'total_deaths' => 'required|integer|min:0',
        'infant_deaths' => 'required|integer|min:0',
        'maternal_deaths' => 'required|integer|min:0',
    ]);

    // Store the data
    VitalStatisticsManagement::create([
        'year' => $request->month_year, // Fix: Use month_year instead of year
        'total_population' => $request->total_population,
        'total_live_births' => $request->total_live_births,
        'total_deaths' => $request->total_deaths,
        'infant_deaths' => $request->infant_deaths,
        'maternal_deaths' => $request->maternal_deaths,
    ]);

    // Redirect with success message
    return redirect()->back()->with('success', 'Vital statistics record added successfully.');
}

    public function show_vital_statistics()
    {
        $data = VitalStatisticsManagement::paginate(10);
        return view('vitalstatistics.vitalstatistics', compact('data'));
    }
    
}
