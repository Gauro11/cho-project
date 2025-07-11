<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Data extends Model

{

    use HasFactory;

    protected $fillable = [
        'category_id',
        'case_name',
        'male_count',
        'date',
        'female_count',
        'percentage',
        'total'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
