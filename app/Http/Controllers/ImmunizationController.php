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
        'vaccine_type' => 'required|string',
        'total_shots' => 'required|integer|min:0',
        'date' => 'required|date',
        'male_vaccinated' => 'required|integer|min:0',
        'female_vaccinated' => 'required|integer|min:0',
        
        'target_population' => 'nullable|string',
        'barangay' => 'required|string',
    ]);

    try {
        $immunization = ImmunizationManagement::findOrFail($request->id);

        $immunization->update([
            'vaccine_name'       => $request->vaccine_name,
            'vaccine_type'       => $request->vaccine_type,
            'total_shots'        => $request->total_shots,
            'date'               => $request->date,
            'male_vaccinated'    => $request->male_vaccinated,
            'female_vaccinated'  => $request->female_vaccinated,
            'age_group'          => $request->age_group,
            'target_population'  => $request->target_population,
            'barangay'           => $request->barangay,
        ]);

        // ✅ Redirect back instead of returning JSON
        return redirect()->back()->with('success', 'Immunization record updated successfully!');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while updating the record.');
    }
}



   public function store_immunization(Request $request)
{
    // Validate the request data
    $request->validate([
        'date' => 'required|date',
        'vaccine_name' => 'required|string|max:255',
        'vaccine_type' => 'required|string|max:255',
        'total_shots' => 'required|integer|min:0',
        'male_vaccinated' => 'required|integer|min:0',
        'female_vaccinated' => 'required|integer|min:0',
        'age_group' => 'required|string|max:255',
        'target_population' => 'nullable|string|max:255',
        'barangay' => 'required|string|max:255',
    ]);

    // ✅ Check if THIS SPECIFIC VACCINE already has a record for this date
    $exists = ImmunizationManagement::where('date', $request->date)
        ->where('vaccine_name', $request->vaccine_name)
        ->exists();

    if ($exists) {
        return redirect()->back()
            ->with('error', 'This vaccine already has a record for this date! Please choose a different date.')
            ->withInput();
    }

    // Create the immunization record
    ImmunizationManagement::create([
        'date' => $request->date,
        'vaccine_name' => $request->vaccine_name,
        'vaccine_type' => $request->vaccine_type,
        'total_shots' => $request->total_shots,
        'male_vaccinated' => $request->male_vaccinated,
        'female_vaccinated' => $request->female_vaccinated,
        'age_group' => $request->age_group,
        'target_population' => $request->target_population,
        'barangay' => $request->barangay,
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

            $allowedSorts = ['created_at', 'date', 'vaccine_name', 'vaccine_type', 'male_vaccinated', 'female_vaccinated', 'age_group', 'barangay'];
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
            $ids = $request->input('ids');

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