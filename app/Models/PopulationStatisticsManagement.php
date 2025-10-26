<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PopulationStatisticsManagement extends Model
{
    use HasFactory;

    protected $table = 'population_statistics_management';

    protected $fillable = [
        'location',
        'year_month',
        'population',
    ];
}
