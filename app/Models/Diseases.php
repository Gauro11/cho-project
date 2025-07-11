<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Diseases extends Model
{
    use HasFactory;

    protected $fillable = [
        'diseases',
        'causative_agent',
        'site_of_infection',
        'mode_of_transmission',
        'symptoms',
    ];
}
