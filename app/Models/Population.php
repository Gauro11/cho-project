<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Population extends Model
{
    use HasFactory;

    protected $table = 'population_statistics_management'; // make sure it matches your actual table name

  protected $fillable = [
    'location',
    'year_month',
    'population',
];

}
