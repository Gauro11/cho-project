<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImmunizationManagement;
use Illuminate\Support\Facades\Auth;

use App\Imports\ImmunizationImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;






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

   

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    Excel::import(new ImmunizationImport, $request->file('file'));

    return back()->with('success', 'Immunization records imported successfully.');
}

// public function index(Request $request)
// {
//     $search = $request->search;
//     $estimatedPopulation = 3000;

//     $data = \App\Models\YourModel::when($search, function ($query) use ($search, $estimatedPopulation) {
//         $query->where(function ($q) use ($search, $estimatedPopulation) {
//             $q->where('vaccine_name', 'like', "%$search%")
//               ->orWhere('male_vaccinated', 'like', "%$search%")
//               ->orWhere('female_vaccinated', 'like', "%$search%")
//               ->orWhereRaw("male_vaccinated + female_vaccinated like ?", ["%$search%"])
//               ->orWhereRaw("DATE_FORMAT(date, '%Y') like ?", ["%$search%"])
//               ->orWhereRaw("ROUND(((male_vaccinated + female_vaccinated)/?) * 100, 2) like ?", [$estimatedPopulation, "%$search%"]);
//         });
//     })
//     ->orderBy('date', 'desc')
//     ->paginate(10)
//     ->withQueryString();

//     return view('your-blade-file-name', compact('data'));
// }

}

