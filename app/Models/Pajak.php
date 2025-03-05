<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Pajak extends Model
{
    protected $table = 'pajak';
    protected $guarded = ['id'];

    public function getJumlahGajiAttribute()
    {
        return $this->gapok + $this->tjk + $this->tjb + $this->tjf + $this->tjfu;
    }
    public function getJumlahTunjanganAttribute()
    {
        return $this->pagu;
    }

    public function getJumlahPenghasilanAttribute()
    {
        return $this->jumlah_gaji + $this->jumlah_tunjangan;
    }
    public function getIuranSatuPersenAttribute()
    {
        $nilai = $this->jumlah_penghasilan ?? 0; // Ganti 'nilai' dengan kolom yang relevan di database
        return $nilai >= 12000000 ? 120000 : $nilai * 0.01;
    }
    public function getIuranEmpatPersenAttribute()
    {
        return $this->iuran_satu_persen * 4;
    }
    public function getGajiSatuPersenAttribute()
    {
        return $this->jumlah_gaji * 1 / 100;
    }
    public function getGajiEmpatPersenAttribute()
    {
        return $this->gaji_satu_persen * 4;
    }
    public function getTppSatuPersenAttribute()
    {
        return round($this->iuran_satu_persen) - round($this->gaji_satu_persen);
    }
    public function getTppEmpatPersenAttribute()
    {
        return $this->tpp_satu_persen * 4;
    }
    public function getPTKPAttribute()
    {
        $statusKawin = $this->status_kawin == 1 ? 'K' : 'TK';
        $jumlahTanggungan = $this->jumlah_tanggungan;
        return $statusKawin . '/' . $jumlahTanggungan;
    }
    public function getTotalPenghasilanAttribute()
    {
        return $this->gaji + $this->tpp + $this->tpp_plt;
    }
    public function getKelompokAttribute()
    {
        $ptkp = $this->PTKP;  // Mengambil nilai PTKP, seperti K/2 atau TK/1

        // Menentukan kelompok berdasarkan PTKP
        switch ($ptkp) {
            case 'TK/0':
            case 'TK/1':
            case 'K/0':
                return 'TER A';  // Kelompok A untuk PTKP TK/0, TK/1, K/0
            case 'TK/2':
            case 'K/1':
                return 'TER B';  // Kelompok B untuk PTKP TK/2, K/1
            case 'TK/3':
            case 'K/2':
                return 'TER B';  // Kelompok B untuk PTKP TK/3, K/2
            case 'K/3':
                return 'TER C';  // Kelompok C untuk PTKP K/3
            default:
                return 'Unknown'; // Jika PTKP tidak sesuai dengan nilai yang diharapkan
        }
    }
    public function getTarifAttribute()
    {
        $penghasilan = $this->total_penghasilan;  // Ambil penghasilan dari field pajak
        $kelompok = $this->kelompok;  // Ambil kelompok berdasarkan PTKP (TER A, TER B, TER C)

        // Menentukan tarif berdasarkan kelompok dan penghasilan
        $tarif = null;

        // Cari tarif berdasarkan kelompok dan penghasilan
        $tarifData = DB::table('tarif')
            ->where('ter', $kelompok)  // Sesuaikan dengan kelompok
            ->where('mulai', '<=', $penghasilan)  // Mulai tarif <= penghasilan
            ->where(function ($query) use ($penghasilan) {
                // Jika Sampai ada dan penghasilan <= Sampai, maka pilih tarif tersebut
                $query->where('sampai', '>=', $penghasilan)
                    ->orWhereNull('sampai');
            })
            ->orderBy('mulai', 'desc')  // Urutkan berdasarkan Mulai untuk memilih rentang yang tepat
            ->first();

        // Jika ada tarif yang ditemukan
        if ($tarifData) {
            $tarif = $tarifData->tarif;  // Ambil nilai tarif
        }

        return $tarif;
    }
    public function getPphPenghasilanAttribute()
    {
        return round($this->total_penghasilan * $this->tarif / 100);
    }
    public function getPphTerutangAttribute()
    {
        return round($this->pph_penghasilan - $this->pph_gaji);
    }
}
