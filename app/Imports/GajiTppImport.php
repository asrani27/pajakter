<?php

namespace App\Imports;

use App\Models\Pajak;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class GajiTppImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $bulan_tahun_id;

    public function __construct($id)
    {
        $this->bulan_tahun_id = $id;
    }

    public function model(array $row)
    {
        // Cek apakah data sudah ada berdasarkan 'bulan_tahun_id' dan 'nip'
        $existingPajak = Pajak::where('bulan_tahun_id', $this->bulan_tahun_id)
            ->where('nip', $row[0])
            ->first();

        // Jika data sudah ada, tidak perlu menyimpan
        if ($existingPajak) {
            return null;
        }
        return new Pajak([
            'bulan_tahun_id' => $this->bulan_tahun_id,
            'nip' => $row[0],
            'nama' => $row[1],
            'status_kawin' => $row[2],
            'jumlah_tanggungan' => $row[4],
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
