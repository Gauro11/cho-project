<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MorbidityMortalityManagement; 

class TrendsController extends Controller
{
  public function getCases($category)
{
    $cases = DB::table('morbidity_mortality_management')
        ->where('category', $category)
        ->distinct()
        ->pluck('case_name');

    return response()->json($cases);
}


}
