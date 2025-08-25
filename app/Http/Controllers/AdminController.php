<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use App\Models\Diseases;
use App\Models\Category;
use App\Models\Year;

use App\Models\Data;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;






class AdminController extends Controller

{

    public function fetchTrendData($category)
    {
        $data = [];

        switch ($category) {
            case 'morbidity':
            case 'mortality':
                $data = MorbidityMortalityManagement::where('category', $category)
                    ->orderBy('date')
                    ->get(['date', 'male_count', 'female_count']);
                break;
            case 'vital_statistics':
                $data = VitalStatisticsManagement::orderBy('year')->get(['year', 'total_deaths']);
                break;
            case 'population_statistics':
                $data = PopulationStatisticsManagement::orderBy('date')->get(['date', 'population']);
                break;
            case 'immunization':
                $data = ImmunizationManagement::orderBy('date')->get(['date', 'male_vaccinated', 'female_vaccinated']);
                break;
        }

        // Format data for Chart.js
        $formattedData = [
            'labels' => $data->pluck('date'),
            'data' => $data->pluck('male_count')->merge($data->pluck('female_count'))
        ];

        // Predict next 2 months (Basic Forecasting)
        $predictedData = $this->predictTrend($data->pluck('male_count')->merge($data->pluck('female_count')));

        return response()->json([
            'trendData' => $formattedData,
            'predictedData' => $predictedData
        ]);
    }

    private function predictTrend($historicalData)
    {
        $trend = $historicalData->average(); // Basic trend calculation
        return [
            'nextMonth' => round($trend * 1.05),
            'twoMonths' => round($trend * 1.10)
        ];
    }


    public function create_staff(Request $request)
    {
        $validatedData = $request->validate([
            'staff_id' => 'required|unique:users,staff_id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);
    
        if (!$validatedData) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
    
        // Generate password as LASTNAMESTAFFID (Uppercase)
        $password = strtoupper($request->last_name) . $request->staff_id;
    
        $staff = User::create([
            'staff_id' => $request->staff_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'usertype' => 'staff',
            'password' => Hash::make($password),
        ]);
    
        return redirect()->back()->with('success', 'Staff added successfully! Default password: ' . $password);
    }
    
    public function update(Request $request, $id)
    {
        \Log::info([
            "Route Parameter ID" => $id,
            "Received ID from Request" => $request->id,
            "Full Request" => $request->all()
        ]);
    
        // Ensure ID is received
        if (!$id) {
            return back()->with('error', 'ID is missing!');
        }
    
        $staff = User::findOrFail($id);
        $staff->first_name = $request->first_name;
        $staff->last_name = $request->last_name;
        $staff->usertype = 'staff';
        $staff->save();
    }

    
    

    /**
     * Remove the specified staff member from storage.
     */
    public function delete_staff($id)
    {
        $staff = User::find($id);

        if (!$staff) {
            return response()->json(['success' => false, 'message' => 'Staff not found.'], 404);
        }

        $staff->delete();

        return response()->json(['success' => true, 'message' => 'Staff deleted successfully.']);
    }

    public function update_staff(Request $request, $id)
{
    $staff = User::find($id);

    if (!$staff) {
        return back()->with('error', 'Staff not found.');
    }

    $staff->first_name = $request->first_name;
    $staff->last_name = $request->last_name;
    $staff->save();

    return back()->with('success', 'Staff updated successfully!');
}


    public function update_data(Request $request)
{
    $data = Data::findOrFail($request->id);
    $data->case_name = $request->case_name;
    $data->male_count = $request->male_count;
    $data->female_count = $request->female_count;
    $data->percentage = $request->percentage;
    $data->date= $request->date;

    $data->save();

    return redirect()->route('data.index')->with('success', 'Data updated successfully!');
}

public function delete_data($id)
{
    $data = Data::findOrFail($id);
    $data->delete();

    return redirect()->route('data.index')->with('success', 'Data deleted successfully');
}



public function create_data(Request $request)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'case_name' => 'required|string',
        'date' => 'required|date',
        'male_count' => 'required|integer|min:0',
        'female_count' => 'required|integer|min:0',
        'percentage' => 'required|numeric|min:0', // Validate percentage
    ]);

    \Log::info('Percentage received from form: ' . $request->percentage);

    Data::create([
        'category_id' => $request->category_id,
        'case_name' => $request->case_name,
        'male_count' => $request->male_count,
        'female_count' => $request->female_count,
        'date' => $request->date,
        'percentage' => round($request->percentage, 2), // Store the correct value
    ]);

    return redirect(url('/show_disease'))->with('success', 'Data added successfully');
}


    
    public function delete_category($id)
{
    $category = Category::find($id);
    
    if (!$category) {
        return redirect()->back()->with('error', 'Category not found.');
    }

    $category->delete();
    return redirect()->back()->with('success', 'Category deleted successfully.');
}

public function search(Request $request)
{
    $query = $request->input('search');

    $data = DataModel::where('case_name', 'LIKE', "%{$query}%")
        ->orWhere('male_count', 'LIKE', "%{$query}%")
        ->orWhere('female_count', 'LIKE', "%{$query}%")
        ->orWhere('percentage', 'LIKE', "%{$query}%")
        ->get();

    return view('partials.data-table', compact('data')); 
}



public function delete_year($id)
{
    $year = Year::find($id);
    
    if (!$year) {
        return redirect()->back()->with('error', 'Year not found.');
    }

    $year->delete();
    return redirect()->back()->with('success', 'Year deleted successfully.');
}
public function filter_category(Request $request)
{
    $categories = Category::all(); // Fetch all categories
    $selectedCategory = $request->input('category_id'); // Get selected category

    // Filter data based on selected category and paginate results
    $data = Data::when($selectedCategory, function ($query) use ($selectedCategory) {
        return $query->where('category_id', $selectedCategory);
    })->paginate(10); // Paginate results (10 items per page)

    return view('staff.disease', compact('categories', 'data', 'selectedCategory'));
}



    public function create_category(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        Category::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->back()->with('success', 'Category added successfully!');
    }

    
    public function create_year(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:255',
        ]);

        Year::create([
            'year' => $request->year,
        ]);

        return redirect()->back()->with('success', 'Year added successfully!');
    }

    public function update_category(Request $request)
{
    $request->validate([
        'id' => 'required|exists:categories,id',
        'category_name' => 'required|string|max:255',
    ]);

    $category = Category::findOrFail($request->id);
    $category->update(['category_name' => $request->category_name]);

    return redirect()->back()->with('success', 'Category updated successfully!');
}

public function update_year(Request $request, $id)
{
    $year = Year::find($id);
    if (!$year) {
        return redirect()->back()->with('error', 'Year not found');
    }
    $year->update([
        'year' => $request->year
    ]);
    return redirect()->back()->with('success', 'Year updated successfully');
}



    public function index(){
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            if ($usertype == 'user') {
                $user = Auth::user();
                return view('staff.index');
            }elseif ($usertype == 'admin') {

                $barangays = DB::table('population_statistics_management')->get();


                $morbidityCases = DB::table('morbidity_mortality_management')
                ->where('category', 'morbidity')
                ->get();
        
                $mortalityCases = DB::table('morbidity_mortality_management')
                ->where('category', 'mortality')
                ->get();
                $vitalStatisticsData = DB::table('vital_statistics_management')->get();
                $immunizationData = DB::table('immunization_management')->get();

        
                return view('admin.index', compact('morbidityCases', 'barangays','mortalityCases', 'vitalStatisticsData', 'immunizationData'));            
            }
            elseif ($usertype == 'mortality and morbidity records manager') {
                $morbidityCases = DB::table('morbidity_mortality_management')
                ->where('category', 'morbidity')
                ->get();
        
                $mortalityCases = DB::table('morbidity_mortality_management')
                ->where('category', 'mortality')
                ->get();
        
                return view('morbiditymortality.index', compact('morbidityCases', 'mortalityCases'));            }
            elseif ($usertype == 'vital statistics records manager') {
                $vitalStatisticsData = DB::table('vital_statistics_management')->get();

                return view('vitalstatistics.index', compact('vitalStatisticsData'));            }
            elseif ($usertype == 'staff') {
                $barangays = DB::table('population_statistics_management')->get();


                $morbidityCases = DB::table('morbidity_mortality_management')
                ->where('category', 'morbidity')
                ->get();
        
                $mortalityCases = DB::table('morbidity_mortality_management')
                ->where('category', 'mortality')
                ->get();
                $vitalStatisticsData = DB::table('vital_statistics_management')->get();
                $immunizationData = DB::table('immunization_management')->get();

                
            
                    return view('staff.index', compact('morbidityCases', 'barangays','mortalityCases', 'vitalStatisticsData', 'immunizationData'));            }


             else {
                return redirect()->back()->withErrors(['error' => 'User type not recognized.']);
            }
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Please log in first.']);
        }
        }

        
        public function show_year()
        {
            $years = Year::all(); // Fetch all categories
            return view('admin.year', compact('years'));
        }

        
        public function show_category()
        {
            $categories = Category::all(); // Fetch all categories
            return view('admin.category', compact('categories'));
        }
        

        public function show_trends()
        {
            return view('staff.trends');
        }

       public function show_staff()
{
    $roles = [
        'mortality and morbidity records manager', 
        'vital statistics records manager', 
        'immunization records manager',
        'staff' // ✅ Add this so they appear
    ];

    $staff = User::whereIn('usertype', $roles)->paginate(10);

    return view('admin.staff', compact('staff'));
}


        
    

        public function show_disease(Request $request)
        {
            $selectedCategory = $request->category_id;
            $categories = Category::select('categories.*')
    ->withSum('data as total_male', 'male_count')
    ->withSum('data as total_female', 'female_count')
    ->get();


         
            $query = Data::query();
            
            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory);
            }
        
            $totalCases = $query->sum(DB::raw('male_count + female_count')); // Get total cases
        
            if ($request->ajax()) {
                return response()->json($data->items());
            }
        
            $data = $query->paginate(10)->withQueryString();
        
            return view('staff.disease', compact('data', 'categories', 'selectedCategory', 'totalCases'));
        }
        
        
        
        
        public function update_disease($id)
        {
            $disease = Diseases::findOrFail($id);
            return view('staff.update_disease', compact('disease'));
        }
        
        public function edit_disease(Request $request, $id)
        {
            $request->validate([
                'diseases' => 'required',
                'causative_agent' => 'required',
                'site_of_infection' => 'required',
                'mode_of_transmission' => 'required',
                'symptoms' => 'required',
            ]);
        
            $disease = Diseases::findOrFail($id);
            $disease->update([
                'diseases' => $request->input('diseases'),
                'causative_agent' => $request->input('causative_agent'),
                'site_of_infection' => $request->input('site_of_infection'),
                'mode_of_transmission' => $request->input('mode_of_transmission'),
                'symptoms' => $request->input('symptoms'),
            ]);
        
            return redirect()->back()->with('success', 'Disease updated successfully!');
        }
        

    public function add_disease(Request $request)
    {
        $request->validate([
            'diseases' => 'required|string|max:255',
            'causative_agent' => 'required|string|max:255',
            'site_of_infection' => 'required|string|max:255',
            'mode_of_transmission' => 'required|string|max:255',
            'symptoms' => 'required|string',
        ]);

        $disease = new Diseases();
        $disease->diseases = $request->input('diseases');
        $disease->causative_agent = $request->input('causative_agent');
        $disease->site_of_infection = $request->input('site_of_infection');
        $disease->mode_of_transmission = $request->input('mode_of_transmission');
        $disease->symptoms = $request->input('symptoms');
        $disease->save();

        return redirect()->back()->with('success', 'Disease added successfully!');
    }

    public function delete_disease($id)
{
    $disease = Diseases::findOrFail($id);
    $disease->delete();
    return redirect()->back()->with('success', 'Disease Deleted successfully!');
}


}
