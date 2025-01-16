<?php

namespace App\Imports;

use App\Models\Pajak;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class GajiBpjsImport implements ToModel, WithStartRow
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
                    'gapok' => $row[4],
                    'tjk' => $row[5],
                    'tjb' => $row[6],
                    'tjf' => $row[7],
                    'tjfu' => $row[8]
                ]);
        } else {
            return new Pajak([
                'bulan_tahun_id' => $this->bulan_tahun_id,
                'nip' => $row[0],
                'nama' => $row[1],
                'gapok' => $row[4],
                'tjk' => $row[5],
                'tjb' => $row[6],
                'tjf' => $row[7],
                'tjfu' => $row[8]
            ]);
        }
    }
    public function startRow(): int
    {
        return 2;
    }
}
