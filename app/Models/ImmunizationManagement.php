<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ImmunizationManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'vaccine_name',
        'male_vaccinated',
        'female_vaccinated',
    ];
}
