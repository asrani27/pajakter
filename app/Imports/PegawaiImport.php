<?php

namespace App\Imports;

use App\Models\Pajak;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PegawaiImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $bulan_tahun_id;
    protected $skpd_id;

    public function __construct($id, $skpd_id)
    {
        $this->bulan_tahun_id = $id;
        $this->skpd_id = $skpd_id;
    }
    public function model(array $row)
    {
        return new Pajak([
            'bulan_tahun_id' => $this->bulan_tahun_id,
            'skpd_id' => $this->skpd_id,
            'nip' => $row[0],
            'nama' => $row[1],
            'status_kawin' => $row[2],
            'jumlah_tanggungan' => $row[5],
            'pph_gaji' => $row[11],
            'gaji' => $row[12],
            'gapok' => $row[6],
            'tjk' => $row[7],
            'tjb' => $row[8],
            'tjf' => $row[9],
            'tjfu' => $row[10],
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
