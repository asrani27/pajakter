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
        $pph_gaji = $row[11];
        $gaji = $row[12];
        // dd(in_array($nip, $this->existingNips), $this->existingNips);
        // dd('d', $nip, $this->existingNips);
        // dd($this->existingNips[$nip]);
        // Cek jika NIP sudah ada di database
        if (in_array($nip, $this->existingNips)) {

            // Ambil ID pajak yang sudah ada
            $pajakId = array_search($nip, $this->existingNips);
            
            // Update jumlah_tanggungan jika data sudah ada
            Pajak::where('id', $pajakId)
                ->update([
                    'pph_gaji' => $pph_gaji,
                    'gaji' => $gaji
                ]);
        } else {
            return new Pajak([
                'bulan_tahun_id' => $this->bulan_tahun_id,
                'nip' => $row[0],
                'nama' => $row[1],
                'status_kawin' => $row[2],
                'jumlah_tanggungan' => $row[4],
                'pph_gaji' => $row[11],
                'gaji' => $row[12],
            ]);
        }
    }
    public function startRow(): int
    {
        return 2;
    }
}
