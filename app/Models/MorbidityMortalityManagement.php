<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class MorbidityMortalityManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'case_name',
        'date',
        'male_count',
        'female_count',
    ];
}
