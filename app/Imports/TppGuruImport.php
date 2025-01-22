<?php

namespace App\Imports;

use App\Models\Pajak;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TppGuruImport implements ToModel, WithStartRow
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
        $nip =  (string) trim($row[2]);

        if (in_array($nip, $this->existingNips)) {

            // Ambil ID pajak yang sudah ada
            $pajakId = array_search($nip, $this->existingNips);

            // Update jumlah_tanggungan jika data sudah ada
            Pajak::where('id', $pajakId)
                ->update([
                    'skpd_id' => 1,
                    'tpp' => $row[3],
                    'pagu' => $row[3],
                    'status_pegawai' => 'GURU',
                    'sheet' => 1,
                ]);
        } else {
        }
    }
    public function startRow(): int
    {
        return 5;
    }
}
