<?php

namespace App\Imports;

use App\Models\Pajak;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ThrImport  implements ToModel, WithStartRow
{
    /**
     * @param Collection $collection
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

            // Update jumlah_thr jika data sudah ada
            Pajak::where('id', $pajakId)
                ->update([
                    'jumlah_thr' => $row[10],
                ]);
        } else {
        }
    }
    public function startRow(): int
    {
        return 2;
    }
}
