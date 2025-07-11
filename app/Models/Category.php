<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Category extends Model


{
    use HasFactory;

    protected $fillable = ['category_name'];

    public function data()
    {
        return $this->hasMany(Data::class, 'category_id', 'id');
    }
    

}
