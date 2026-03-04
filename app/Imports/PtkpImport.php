<?php

namespace App\Imports;

use App\Models\Ptkp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PtkpImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $nip = (string) trim($row[1]);
        
        $existing = Ptkp::where('nip', $nip)->first();
        
        if ($existing) {
            // Update jika data sudah ada
            $existing->update([
                'nama' => $row[2],
                'ptkp' => $row[3]
            ]);
        } else {
            // Insert baru jika belum ada
            return new Ptkp([
                'nip' => $row[1],
                'nama' => $row[2],
                'ptkp' => $row[3]
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}