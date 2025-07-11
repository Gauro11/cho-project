<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImmunizationManagement;


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

public function show_immunization()
{
    $data = ImmunizationManagement::paginate(10);
    return view('immunization.immunization', compact('data'));
}

    // public function show_immunization()
    // {
    //     $data = MorbidityMortalityManagement::where('category', 'mortality')->paginate(10);
    //     return view('morbiditymortality.mortality', compact('data'));
    // }
}
