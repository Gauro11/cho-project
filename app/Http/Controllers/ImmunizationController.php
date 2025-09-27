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

    // Keep vaccine name and date updated
    $immunization->vaccine_name = $request->vaccine_name;
    $immunization->date = $request->date;

    // ✅ Add to existing totals instead of replacing
    $immunization->male_vaccinated = $request->male_vaccinated;
    $immunization->female_vaccinated = $request->female_vaccinated;

    $immunization->save();

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
    if (Auth::guard('staff')->check()) {

        // Default sort: created_at ascending (oldest → newest)
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'asc');

        $allowedSorts = ['created_at', 'date', 'vaccine_name', 'male_vaccinated', 'female_vaccinated'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        $data = ImmunizationManagement::orderBy($sort, $direction)
            ->paginate(10)
            ->appends($request->only(['sort', 'direction']));

        $user = Auth::guard('staff')->user();

        return view('immunization.immunization', compact('data', 'user', 'sort', 'direction'));
    } else {
        return redirect()->route('login')->withErrors(['error' => 'Please log in first.']);
    }
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

public function deleteSelected(Request $request)
{
    try {
        $ids = $request->input('ids'); // dapat array ng mga ID

        if (empty($ids) || !is_array($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No records selected for deletion'
            ], 400);
        }

        $deletedCount = ImmunizationManagement::whereIn('id', $ids)->delete();

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

