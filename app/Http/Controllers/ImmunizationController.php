<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImmunizationManagement;
use Illuminate\Support\Facades\Auth;

use App\Imports\ImmunizationImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ImmunizationTemplateExport;






class ImmunizationController extends Controller
{

    

    
    public function delete_immunization($id)
    {
        $data = ImmunizationManagement::findOrFail($id);
        $data->delete();
    
        return response()->json(['success' => true]);
    }

    public function update_immunization(Request $request)
{
    $request->validate([
        'id' => 'required|exists:immunization_management,id',
        'vaccine_name' => 'required|string',
        'date' => 'required|date',
        'male_vaccinated' => 'required|integer',
        'female_vaccinated' => 'required|integer',
    ]);

    $immunization = ImmunizationManagement::findOrFail($request->id);
    $immunization->update([
        'vaccine_name' => $request->vaccine_name,
        'date' => $request->date,
        'male_vaccinated' => $request->male_vaccinated,
        'female_vaccinated' => $request->female_vaccinated,
    ]);

    return response()->json(['success' => true]);
}

    public function store_immunization(Request $request)
{
    // Validate the request data
    $request->validate([
        'date' => 'required|date',
        'vaccine_name' => 'required|string|max:255',
        'male_vaccinated' => 'required|integer|min:0',
        'female_vaccinated' => 'required|integer|min:0',
    ]);

    // Create the immunization record
    ImmunizationManagement::create([
        'date' => $request->date,
        'vaccine_name' => $request->vaccine_name,
        'male_vaccinated' => $request->male_vaccinated,
        'female_vaccinated' => $request->female_vaccinated,
    ]);

    // Redirect with success message
    return redirect()->back()->with('success', 'Immunization record added successfully.');
}


public function show_immunization(Request $request)
{
    if (!Auth::guard('staff')->check()) {
        return redirect()->route('login')->withErrors(['error' => 'Please log in first.']);
    }

    $sort = $request->get('sort', 'date');
    $direction = $request->get('direction', 'asc');

    $allowedSorts = ['date', 'vaccine_name', 'male_vaccinated', 'female_vaccinated'];
    if (!in_array($sort, $allowedSorts)) {
        $sort = 'date';
    }

    $data = ImmunizationManagement::orderBy($sort, $direction)
        ->paginate(10)
        ->appends($request->only(['sort', 'direction']));

    if ($request->ajax()) {
        return view('immunization.partials.table', compact('data', 'sort', 'direction'))->render();
    }

    $user = Auth::guard('staff')->user();
    return view('immunization.immunization', compact('data', 'user', 'sort', 'direction'));
}




    // public function show_immunization()
    // {
    //     $data = MorbidityMortalityManagement::where('category', 'mortality')->paginate(10);
    //     return view('morbiditymortality.mortality', compact('data'));
    // }

   

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    Excel::import(new ImmunizationImport, $request->file('file'));

    return back()->with('success', 'Immunization records imported successfully.');
}

public function immunizationTemplate()
{
    return Excel::download(new ImmunizationTemplateExport, 'immunization_template.xlsx');
}

public function deleteAll()
{
    try {
        $deletedCount = ImmunizationManagement::count(); // Get count before deletion
        ImmunizationManagement::truncate(); // Deletes all records
        
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

