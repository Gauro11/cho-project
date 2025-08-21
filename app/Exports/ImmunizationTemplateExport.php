<?php

namespace App\Exports;

use App\Models\ImmunizationManagement;
use Maatwebsite\Excel\Concerns\FromCollection;

class ImmunizationTemplateExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ImmunizationManagement::all();
    }
}
