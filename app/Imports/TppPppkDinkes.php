<?php

namespace App\Imports;

use App\Models\Pajak;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TppPppkDinkes implements ToModel, WithStartRow
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

        $nip =  (string) str_replace(' ', '', $row[1]);

        if (in_array($nip, $this->existingNips)) {

            // Ambil ID pajak yang sudah ada
            $pajakId = array_search($nip, $this->existingNips);

            // Update jumlah_tanggungan jika data sudah ada
            Pajak::where('id', $pajakId)
                ->update([
                    'skpd_id' => Auth::user()->skpd->id,
                    'tpp' => $row[3],
                    'pagu' => $row[3],
                    'status_pegawai' => 'PPPK',
                ]);

            //Log::channel('importtpp')->info("NIP $nip ditemukan pada existingNips dengan ID Pajak: $pajakId");
        } else {
            Log::channel('importtpp')->warning("NIP $nip tidak ditemukan pada existingNips");
            // $new = new Pajak();
            // $new->nip = $nip;
            // $new->bulan_tahun_id = $this->bulan_tahun_id;
            // $new->nama = $row[2];
            // $new->skpd_id = Auth::user()->skpd->id;
            // $new->tpp = $row[3];
            // $new->pagu = $row[3];
            // $new->status_pegawai = 'PPPK';
            // $new->save();
        }
    }
    public function startRow(): int
    {
        return 2;
    }
}
