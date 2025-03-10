<?php

namespace App\Imports;

use App\Models\Pajak;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class GajiPppkImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $bulan_tahun_id;
    protected $existingNips;

    public function __construct($id)
    {
        $this->bulan_tahun_id = $id;

        $this->existingNips = Pajak::where('bulan_tahun_id', $this->bulan_tahun_id)
            ->pluck('nip', 'id')
            ->toArray();
    }
    public function model(array $row)
    {
        $nip =  (string) trim($row[0]);

        if (in_array($nip, $this->existingNips)) {

            // Ambil ID pajak yang sudah ada
            $pajakId = array_search($nip, $this->existingNips);

            // Update jumlah_tanggungan jika data sudah ada
            Pajak::where('id', $pajakId)
                ->update([
                    'status_kawin' => $row[4],
                    'jumlah_tanggungan' => $row[5],
                    'gapok' => $row[6],
                    'tjk' => $row[7],
                    'tjb' => $row[8],
                    'tjf' => $row[9],
                    'tjfu' => $row[10],
                    'pph_gaji' => $row[11],
                    'gaji' => $row[12],
                    'unit_kerja' => $row[13] == null ? null : $row[13],
                    'status_pegawai' => 'PPPK'
                ]);
        } else {
            return new Pajak([
                'bulan_tahun_id' => $this->bulan_tahun_id,
                'nip' => $row[0],
                'nama' => $row[1],
                'status_kawin' => $row[4],
                'jumlah_tanggungan' => $row[5],
                'gapok' => $row[6],
                'tjk' => $row[7],
                'tjb' => $row[8],
                'tjf' => $row[9],
                'tjfu' => $row[10],
                'pph_gaji' => $row[11],
                'gaji' => $row[12],
                'unit_kerja' => $row[13] == null ? null : $row[13],
                'status_pegawai' => 'PPPK'
            ]);
        }
    }
    public function startRow(): int
    {
        return 2;
    }
}
