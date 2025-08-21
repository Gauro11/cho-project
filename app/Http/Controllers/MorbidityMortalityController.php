<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\MorbidityMortalityManagement;
use Illuminate\Support\Facades\Auth;
use App\Imports\MortalityImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MorbidityImport;




class MorbidityMortalityController extends Controller
{

    public function delete_morbidity($id)
{
    $record = MorbidityMortalityManagement::findOrFail($id);
    $record->delete();

    return response()->json(['success' => true]);
}

public function delete_mortality($id)
{
    $record = MorbidityMortalityManagement::findOrFail($id);
    $record->delete();

    return response()->json(['success' => true]);
}

public function delete($id)
{
    $record = MorbidityMortalityManagement::findOrFail($id);
    $record->delete();

    return response()->json(['success' => true]);
}

public function update_morbidity(Request $request)
{
    // Validate request data
    $validated = $request->validate([
        'id' => 'required|exists:morbidity_mortality_management,id',
        'date' => 'required|date',
        'case_name' => 'required|string|max:255',
        'male_count' => 'required|integer|min:0',
        'female_count' => 'required|integer|min:0',
    ]);

    try {
        // Find and update the record
        $record = MorbidityMortalityManagement::findOrFail($validated['id']);
        $record->update([
            'date' => $validated['date'],
            'case_name' => $validated['case_name'],
            'male_count' => $validated['male_count'],
            'female_count' => $validated['female_count'],
        ]);

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}



    public function update_mortality(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'id' => 'required|exists:morbidity_mortality_management,id',
            'date' => 'required|date',
            'case_name' => 'required|string|max:255',
            'male_count' => 'required|integer|min:0',
            'female_count' => 'required|integer|min:0',
        ]);
    
        try {
            // Find and update the record
            $record = MorbidityMortalityManagement::findOrFail($validated['id']);
            $record->update([
                'date' => $validated['date'],
                'case_name' => $validated['case_name'],
                'male_count' => $validated['male_count'],
                'female_count' => $validated['female_count'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store_morbidity(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'case_name' => 'required|string|max:255',
            'male_count' => 'required|integer|min:0',
            'female_count' => 'required|integer|min:0',
        ]);

        // Calculate total cases
        $totalCases = $request->male_count + $request->female_count;

        // Calculate total cases in the 'mortality' category for percentage calculation
        $totalCategoryCases = MorbidityMortalityManagement::where('category', 'morbidity')->sum(DB::raw('male_count + female_count'));

        // Calculate percentage
        $percentage = $totalCategoryCases > 0 
            ? ($totalCases / $totalCategoryCases) * 100 
            : 0;

        MorbidityMortalityManagement::create([
            'category' => 'morbidity',
            'case_name' => $request->case_name,
            'date' => $request->date,
            'male_count' => $request->male_count,
            'female_count' => $request->female_count,
        ]);

        return redirect()->back()->with('success', 'Mortality data saved successfully.');
    }

    public function store_mortality(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'case_name' => 'required|string|max:255',
            'male_count' => 'required|integer|min:0',
            'female_count' => 'required|integer|min:0',
        ]);

        // Calculate total cases
        $totalCases = $request->male_count + $request->female_count;

        // Calculate total cases in the 'mortality' category for percentage calculation
        $totalCategoryCases = MorbidityMortalityManagement::where('category', 'mortality')->sum(DB::raw('male_count + female_count'));

        // Calculate percentage
        $percentage = $totalCategoryCases > 0 
            ? ($totalCases / $totalCategoryCases) * 100 
            : 0;

        MorbidityMortalityManagement::create([
            'category' => 'mortality',
            'case_name' => $request->case_name,
            'date' => $request->date,
            'male_count' => $request->male_count,
            'female_count' => $request->female_count,
        ]);

        return redirect()->back()->with('success', 'Mortality data saved successfully.');
    }
    
    public function show_morbidity()
    {
        $data = MorbidityMortalityManagement::where('category', 'morbidity')->paginate(10);
        return view('morbiditymortality.morbidity', compact('data'));
    }
    public function show_mortality()
    {
        $data = MorbidityMortalityManagement::where('category', 'mortality')->paginate(10);
        return view('morbiditymortality.mortality', compact('data'));
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    Excel::import(new MortalityImport, $request->file('file'));

   return back()->with('success', 'Mortality records imported successfully.');

}

 public function imports(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    Excel::import(new MorbidityImport, $request->file('file'));

   return back()->with('success', 'Morbidity records imported successfully.');

}

public function deleteAllMorbidity()
{
    try {
        // Use a transaction for safety
        return DB::transaction(function () {
            $query = MorbidityMortalityManagement::where('category', 'morbidity');

            $deletedCount = $query->count();

            if ($deletedCount > 0) {
                $query->delete();
            }

            return response()->json([
                'success' => 1,
                'message' => $deletedCount > 0 
                    ? 'All morbidity records deleted successfully' 
                    : 'No morbidity records found',
                'deleted_count' => $deletedCount
            ]);
        });
    } catch (\Exception $e) {
        return response()->json([
            'success' => 0,
            'message' => 'Failed to delete morbidity records: ' . $e->getMessage()
        ], 500);
    }
}


}
