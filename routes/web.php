<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MorbidityMortalityController;
use App\Http\Controllers\VitalStatisticsController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\PopulationController;
use App\Http\Controllers\DownloadController;
 


Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () { 
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/datasearch', [AdminController::class, 'search'])->name('data.search');

Route::get('/data', [AdminController::class, 'filter_category'])->name('data.index');
Route::post('/data/store', [AdminController::class, 'create_data'])->name('data.store');
Route::put('/data/update', [AdminController::class, 'update_data'])->name('data.update');
Route::delete('/data/{id}', [AdminController::class, 'delete_data'])->name('data.destroy');

Route::post('/staff/store', [AdminController::class, 'create_staff'])->name('staff.store');
Route::put('/staff/update/{id}', [AdminController::class, 'update'])->name('staff.update');
Route::delete('/staff/{id}', [AdminController::class, 'delete_staff'])->name('staff.destroy');

Route::post('/categories/store', [AdminController::class, 'create_category'])->name('categories.store');
Route::put('/categories/{id}', [AdminController::class, 'update_category'])->name('categories.update');
Route::delete('/categories/{id}', [AdminController::class, 'delete_category'])->name('categories.destroy');

Route::post('/year/store', [AdminController::class, 'create_year'])->name('year.store');
Route::put('/year/{id}', [AdminController::class, 'update_year'])->name('year.update');
Route::delete('/year/{id}', [AdminController::class, 'delete_year'])->name('year.destroy');

route::get('/home',[AdminController::class,'index']);

route::get('/show_category',[AdminController::class,'show_category']);
route::get('/show_year',[AdminController::class,'show_year']);
route::get('/show_staff',[AdminController::class,'show_staff']);
route::get('/show_disease',[AdminController::class,'show_disease']);
route::get('/show_trends',[AdminController::class,'show_trends']);

Route::get('/update_disease/{id}', [AdminController::class, 'update_disease']);

Route::post('/add_disease', [AdminController::class, 'add_disease']);
Route::post('/edit_disease/{id}', [AdminController::class, 'edit_disease']);
Route::post('/delete_disease/{id}', [AdminController::class, 'delete_disease']);

Route::get('/show_morbidity', [MorbidityMortalityController::class, 'show_morbidity']);
Route::get('/show_mortality', [MorbidityMortalityController::class, 'show_mortality']);
Route::get('/show_immunization', [ImmunizationController::class, 'show_immunization']);
Route::get('/show_vital_statistics', [VitalStatisticsController::class, 'show_vital_statistics']);
Route::get('/show_population', [PopulationController::class, 'show_population']);

Route::post('store/mortality', [MorbidityMortalityController::class, 'store_mortality'])->name('mortality.store');
Route::put('/mortality/update', [MorbidityMortalityController::class, 'update_mortality'])->name('mortality.update');
Route::delete('/mortality/delete/{id}', [MorbidityMortalityController::class, 'delete_mortality'])->name('mortality.delete');

Route::post('store/morbidity', [MorbidityMortalityController::class, 'store_morbidity'])->name('morbidity.store');
Route::put('/morbidity/update', [MorbidityMortalityController::class, 'update_morbidity'])->name('morbidity.update');
Route::delete('/morbidity/delete/{id}', [MorbidityMortalityController::class, 'delete_morbidity'])->name('morbidity.delete');

Route::post('store/vitalStatiscs', [VitalStatisticsController::class, 'store_vitalstatiscs'])->name('vital_statistics.store');
Route::put('/vital-statistics/update', [VitalStatisticsController::class, 'update_vitalstatiscs'])->name('vital_statistics.update');
Route::delete('/vitalstatistics/delete/{id}', [VitalStatisticsController::class, 'delete_vitalstatistics'])->name('vital_statistics.delete');

Route::post('store/vitalStatiscs', [VitalStatisticsController::class, 'store_vitalstatiscs'])->name('vital_statistics.store');
Route::put('/vital-statistics/update', [VitalStatisticsController::class, 'update_vitalstatiscs'])->name('vital_statistics.update');
Route::delete('/vitalstatistics/delete/{id}', [VitalStatisticsController::class, 'delete_vitalstatistics'])->name('vital_statistics.delete');

Route::post('store/immunization', [ImmunizationController::class, 'store_immunization'])->name('immunization.store');
Route::put('/immunization/update', [ImmunizationController::class, 'update_immunization'])->name('immunization.update');
Route::delete('/immunization/delete/{id}', [ImmunizationController::class, 'delete_immunization'])->name('immunization.delete');

Route::post('store/population', [PopulationController::class, 'store_population'])->name('population.store');
Route::put('/population/update', [PopulationController::class, 'update_population'])->name('population.update');
Route::delete('/population/delete/{id}', [PopulationController::class, 'delete_population'])->name('population.delete');

Route::get('/download-csv', [DownloadController::class, 'exportPopulation'])->name('download.csv');
Route::get('/immunization/export', [DownloadController::class, 'exportImmunization'])->name('immunization.export');
Route::get('/export-vital-statistics', [DownloadController::class, 'exportVitalStatistics'])->name('exportVitalStatistics');
Route::get('/export-morbidity', [DownloadController::class, 'exportMorbidity'])->name('exportMorbidity');
Route::get('/export-mortality', [DownloadController::class, 'exportMortality'])->name('mortality.export');

Route::get('/fetch-trend-data/{category}', [AdminController::class, 'fetchTrendData']);















