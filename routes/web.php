<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MorbidityMortalityController;
use App\Http\Controllers\VitalStatisticsController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\PopulationController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Auth;

// ✅ Root route to fix 404 on http://127.0.0.1:8000/
Route::get('/', function () {
    return redirect('/home'); // Or change to view('welcome');
});


// Authenticated routes
// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () { 
//     Route::get('/home', function () {
//         return view('/home');
//     })->name('home');
// });


Route::post('/login', [LoginController::class, 'login'])->name('login');


// Route::get('/staff', [AdminController::class, 'search'])->name('data.search');


Route::get('/', function () {
    return view('auth.login');
});









// Admin Data Management
Route::get('/datasearch', [AdminController::class, 'search'])->name('data.search');
Route::get('/data', [AdminController::class, 'filter_category'])->name('data.index');
Route::post('/data/store', [AdminController::class, 'create_data'])->name('data.store');
Route::put('/data/update', [AdminController::class, 'update_data'])->name('data.update');
Route::delete('/data/{id}', [AdminController::class, 'delete_data'])->name('data.destroy');

// Staff Management
Route::post('/staff/store', [AdminController::class, 'create_staff'])->name('staff.store');
Route::put('/staff/update/{id}', [AdminController::class, 'update'])->name('staff.update');
Route::delete('/staff/{id}', [AdminController::class, 'delete_staff'])->name('staff.destroy');

// Category and Year Management
Route::post('/categories/store', [AdminController::class, 'create_category'])->name('categories.store');
Route::put('/categories/{id}', [AdminController::class, 'update_category'])->name('categories.update');
Route::delete('/categories/{id}', [AdminController::class, 'delete_category'])->name('categories.destroy');

Route::post('/year/store', [AdminController::class, 'create_year'])->name('year.store');
Route::put('/year/{id}', [AdminController::class, 'update_year'])->name('year.update');
Route::delete('/year/{id}', [AdminController::class, 'delete_year'])->name('year.destroy');

// Admin Views
//  Route::get('/home', [AdminController::class, 'index']);
// Route::get('/staff', [StaffController::class, 'index']);
Route::get('/show_category', [AdminController::class, 'show_category']);
Route::get('/show_year', [AdminController::class, 'show_year']);
Route::get('/show_staff', [AdminController::class, 'show_staff']);
Route::get('/show_disease', [AdminController::class, 'show_disease']);
Route::get('/show_trends', [AdminController::class, 'show_trends']);

// Disease Management
Route::get('/update_disease/{id}', [AdminController::class, 'update_disease']);
Route::post('/add_disease', [AdminController::class, 'add_disease']);
Route::post('/edit_disease/{id}', [AdminController::class, 'edit_disease']);
Route::post('/delete_disease/{id}', [AdminController::class, 'delete_disease']);

// Show Health Data
Route::get('/show_morbidity', [MorbidityMortalityController::class, 'show_morbidity']);
Route::get('/show_mortality', [MorbidityMortalityController::class, 'show_mortality']);
Route::get('/show_immunization', [ImmunizationController::class, 'show_immunization']);
Route::get('/show_vital_statistics', [VitalStatisticsController::class, 'show_vital_statistics']);
Route::get('/show_population', [PopulationController::class, 'show_population']);

// Morbidity & Mortality
Route::post('store/mortality', [MorbidityMortalityController::class, 'store_mortality'])->name('mortality.store');
Route::put('/mortality/update', [MorbidityMortalityController::class, 'update_mortality'])->name('mortality.update');
Route::delete('/mortality/delete/{id}', [MorbidityMortalityController::class, 'delete_mortality'])->name('mortality.delete');

Route::post('store/morbidity', [MorbidityMortalityController::class, 'store_morbidity'])->name('morbidity.store');
Route::put('/morbidity/update', [MorbidityMortalityController::class, 'update_morbidity'])->name('morbidity.update');
Route::delete('/morbidity/delete/{id}', [MorbidityMortalityController::class, 'delete_morbidity'])->name('morbidity.delete');

// Vital Statistics
Route::post('store/vitalStatiscs', [VitalStatisticsController::class, 'store_vitalstatiscs'])->name('vital_statistics.store');
Route::put('/vital-statistics/update', [VitalStatisticsController::class, 'update_vitalstatiscs'])->name('vital_statistics.update');
Route::delete('/vitalstatistics/delete/{id}', [VitalStatisticsController::class, 'delete_vitalstatistics'])->name('vital_statistics.delete');

// Immunization
Route::post('store/immunization', [ImmunizationController::class, 'store_immunization'])->name('immunization.store');
Route::put('/immunization/update', [ImmunizationController::class, 'update_immunization'])->name('immunization.update');
Route::delete('/immunization/delete/{id}', [ImmunizationController::class, 'delete_immunization'])->name('immunization.delete');
Route::post('/immunization/import', [ImmunizationController::class, 'import'])->name('immunization.import');

// Population
Route::post('store/population', [PopulationController::class, 'store_population'])->name('population.store');
Route::put('/population/update', [PopulationController::class, 'update_population'])->name('population.update');
Route::delete('/population/delete/{id}', [PopulationController::class, 'delete_population'])->name('population.delete');

// Export & Download
Route::get('/download-csv', [DownloadController::class, 'exportPopulation'])->name('download.csv');
Route::get('/immunization/export/{type}', [DownloadController::class, 'exportImmunization'])->name('immunization.export');
Route::get('/export-vital-statistics/{type}', [DownloadController::class, 'exportVitalStatistics'])->where('type', 'csv|pdf')->name('exportVitalStatistics');
Route::get('/morbidity/export/{type}', [DownloadController::class, 'exportMorbidity'])->where('type', 'csv|pdf')->name('morbidity.export');
Route::get('/mortality/export/{type}', [DownloadController::class, 'exportMortality'])->where('type', 'csv|pdf')->name('mortality.export');
Route::get('/population/export/{type}', [DownloadController::class, 'exportPopulation'])->where('type', 'csv|pdf')->name('population.export');



// Charts / Trends
Route::get('/fetch-trend-data/{category}', [AdminController::class, 'fetchTrendData']);
Route::post('/population/import', [PopulationController::class, 'import'])->name('population.import');
Route::post('/vital-statistics/import', [VitalStatisticsController::class, 'import'])->name('vital_statistics.import');
Route::post('/mortality/import', [MorbidityMortalityController::class, 'import'])->name('mortality.import');
Route::post('/morbidity/import', [MorbidityMortalityController::class, 'imports'])->name('morbidity.import');




Route::middleware('auth:admin')->group(function () {
    Route::get('/home', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware('auth:staff')->group(function () {
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.dashboard');
});


Route::get('/dagupan-population', [PopulationController::class, 'getDagupanPopulation']);
