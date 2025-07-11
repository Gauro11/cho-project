<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class VitalStatisticsManagement extends Model
{

    protected $table = 'vital_statistics_management';

    protected $fillable = [
        'year',
        'total_population',
        'total_live_births',
        'total_deaths',
        'infant_deaths',
        'maternal_deaths',
    ];
}
