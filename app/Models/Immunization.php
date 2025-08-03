<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImmunizationManagement extends Model
{
    protected $table = 'immunization_management';

    protected $fillable = [
        'date',
        'vaccine_name',
        'male_vaccinated',
        'female_vaccinated',
    ];

    public $timestamps = true;
}


