<?php

namespace App\Exports;

use App\Models\MorbidityMortalityManagement;
use Maatwebsite\Excel\Concerns\FromCollection;

class MorbidityMortalityTemplateExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MorbidityMortalityManagement::all();
    }
}
