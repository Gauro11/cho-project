<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImmunizationManagement extends Model
{
    protected $table = 'immunization_management';

    protected $fillable = [
        'date',
        'vaccine_name',
        'vaccine_type',
        'total_shots',
        'male_vaccinated',
        'female_vaccinated',
        'age_group',
        'target_population',
        'barangay',
    ];
}