<?php

namespace App\Imports;

use App\Models\Pajak;
use Maatwebsite\Excel\Concerns\ToModel;

class GajiBpjsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Pajak([
            //
        ]);
    }
}
