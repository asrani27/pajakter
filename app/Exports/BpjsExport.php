<?php

namespace App\Exports;

use App\Models\Pajak;
use Maatwebsite\Excel\Concerns\FromCollection;

class BpjsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pajak::all();
    }
}
