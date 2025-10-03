<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Diseases;
use App\Models\Category;
use App\Models\Year;
use App\Models\Data;
use App\Models\MorbidityMortalityManagement;
use App\Models\VitalStatisticsManagement;
use App\Models\PopulationStatisticsManagement;
use App\Models\ImmunizationManagement;

class AdminController extends Controller
{
    /* ------------------------------
     * DASHBOARD & ROLE-BASED VIEWS
     * ------------------------------ */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'Please log in first.']);
        }

        $usertype = Auth::user()->usertype;

        switch ($usertype) {
            case 'admin':
                return $this->adminDashboard();
            case 'user':
                return view('staff.index');
            case 'mortality and morbidity records manager':
                return $this->morbidityMortalityDashboard();
            case 'vital statistics records manager':
                return $this->vitalStatisticsDashboard();
            case 'staff':
                return $this->staffDashboard();
            default:
                return back()->withErrors(['error' => 'User type not recognized.']);
        }
    }

    private function adminDashboard()
    {
        $barangays = DB::table('population_statistics_management')->get();
        $morbidityCases = DB::table('morbidity_mortality_management')->where('category', 'morbidity')->get();
        $mortalityCases = DB::table('morbidity_mortality_management')->where('category', 'mortality')->get();
        $vitalStatisticsData = DB::table('vital_statistics_management')->get();
        $immunizationData = DB::table('immunization_management')->get();

        return view('admin.index', compact('morbidityCases', 'barangays', 'mortalityCases', 'vitalStatisticsData', 'immunizationData'));
    }

    private function morbidityMortalityDashboard()
    {
        $morbidityCases = DB::table('morbidity_mortality_management')->where('category', 'morbidity')->get();
        $mortalityCases = DB::table('morbidity_mortality_management')->where('category', 'mortality')->get();
        return view('morbiditymortality.index', compact('morbidityCases', 'mortalityCases'));
    }

    private function vitalStatisticsDashboard()
    {
        $vitalStatisticsData = DB::table('vital_statistics_management')->get();
        return view('vitalstatistics.index', compact('vitalStatisticsData'));
    }

    private function staffDashboard()
    {
        $barangays = DB::table('population_statistics_management')->get();
        $morbidityCases = DB::table('morbidity_mortality_management')->where('category', 'morbidity')->get();
        $mortalityCases = DB::table('morbidity_mortality_management')->where('category', 'mortality')->get();
        $vitalStatisticsData = DB::table('vital_statistics_management')->get();
        $immunizationData = DB::table('immunization_management')->get();

        return view('staff.index', compact('morbidityCases', 'barangays', 'mortalityCases', 'vitalStatisticsData', 'immunizationData'));
    }

    /* ------------------------------
     * STAFF MANAGEMENT
     * ------------------------------ */
    public function show_staff()
    {
        $roles = [
            'mortality and morbidity records manager',
            'vital statistics records manager',
            'immunization records manager',
            'staff'
        ];
        $staff = User::whereIn('usertype', $roles)->paginate(10);
        return view('admin.staff', compact('staff'));
    }

    public function create_staff(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|unique:users,staff_id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);

        $password = strtoupper($validated['last_name']) . $validated['staff_id'];

        User::create([
            'staff_id' => $validated['staff_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'usertype' => 'staff',
            'password' => Hash::make($password),
        ]);

        return back()->with('success', "Staff added! Default password: {$password}");
    }

    public function update_staff(Request $request, $id)
    {
        $staff = User::findOrFail($id);
        $staff->update($request->only(['first_name', 'last_name']));
        return back()->with('success', 'Staff updated successfully!');
    }

    public function delete_staff($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Staff deleted successfully']);
    }

    /* ------------------------------
     * CATEGORY & YEAR MANAGEMENT
     * ------------------------------ */
    public function show_category()
    {
        $categories = Category::all();
        return view('admin.category', compact('categories'));
    }

    public function create_category(Request $request)
    {
        $request->validate(['category_name' => 'required|string|max:255']);
        Category::create(['category_name' => $request->category_name]);
        return back()->with('success', 'Category added successfully!');
    }

    public function update_category(Request $request, $id)
    {
        $request->validate(['category_name' => 'required|string|max:255']);
        Category::findOrFail($id)->update(['category_name' => $request->category_name]);
        return back()->with('success', 'Category updated successfully!');
    }

    public function delete_category($id)
    {
        Category::findOrFail($id)->delete();
        return back()->with('success', 'Category deleted successfully!');
    }

    public function show_year()
    {
        $years = Year::all();
        return view('admin.year', compact('years'));
    }

    public function create_year(Request $request)
    {
        $request->validate(['year' => 'required|string|max:255']);
        Year::create(['year' => $request->year]);
        return back()->with('success', 'Year added successfully!');
    }

    public function update_year(Request $request, $id)
    {
        Year::findOrFail($id)->update(['year' => $request->year]);
        return back()->with('success', 'Year updated successfully!');
    }

    public function delete_year($id)
    {
        Year::findOrFail($id)->delete();
        return back()->with('success', 'Year deleted successfully!');
    }

    /* ------------------------------
     * DISEASE MANAGEMENT
     * ------------------------------ */
    public function show_disease(Request $request)
    {
        $selectedCategory = $request->category_id;
        $categories = Category::withSum('data as total_male', 'male_count')
                              ->withSum('data as total_female', 'female_count')
                              ->get();

        $query = Data::query();
        if ($selectedCategory) {
            $query->where('category_id', $selectedCategory);
        }

        $totalCases = $query->sum(DB::raw('male_count + female_count'));
        $data = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json($data);
        }

        return view('staff.disease', compact('data', 'categories', 'selectedCategory', 'totalCases'));
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
        Diseases::create($request->all());
        return back()->with('success', 'Disease added successfully!');
    }

    public function edit_disease(Request $request, $id)
    {
        $disease = Diseases::findOrFail($id);
        $disease->update($request->all());
        return back()->with('success', 'Disease updated successfully!');
    }

    public function delete_disease($id)
    {
        Diseases::findOrFail($id)->delete();
        return back()->with('success', 'Disease deleted successfully!');
    }

    /* ------------------------------
     * TRENDS & PREDICTIONS
     * ------------------------------ */
    public function fetchTrendData($category)
    {
        $data = match ($category) {
            'morbidity', 'mortality' =>
                MorbidityMortalityManagement::where('category', $category)->orderBy('date')->get(['date','male_count','female_count']),
            'vital_statistics' =>
                VitalStatisticsManagement::orderBy('year')->get(['year','total_deaths']),
            'population_statistics' =>
                PopulationStatisticsManagement::orderBy('date')->get(['date','population']),
            'immunization' =>
                ImmunizationManagement::orderBy('date')->get(['date','male_vaccinated','female_vaccinated']),
            default => collect()
        };

        return response()->json([
            'labels' => $data->pluck('date'),
            'male'   => $data->pluck('male_count'),
            'female' => $data->pluck('female_count'),
            'prediction' => $this->predictTrend($data->pluck('male_count')->merge($data->pluck('female_count')))
        ]);
    }

    private function predictTrend($historicalData)
    {
        $trend = $historicalData->average() ?? 0;
        return [
            'nextMonth' => round($trend * 1.05),
            'twoMonths' => round($trend * 1.10)
        ];
    }
}
