<?php

namespace App\Http\Controllers;

use App\Models\BulanTahun;
use App\Models\Skpd;
use App\Models\Pajak;
use Illuminate\Http\Request;

class PajakGabunganController extends Controller
{

    public function index(Request $request)
    {
        $bulantahun = BulanTahun::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        $skpd = Skpd::orderBy('nama', 'asc')->get();

        return view('superadmin.pajak.gabungan', compact('bulantahun', 'skpd'));
    }

    public function getData(Request $request)
    {
        $query = Pajak::query();

        if ($request->bulan_tahun_id) {
            $query->where('bulan_tahun_id', $request->bulan_tahun_id);
        }

        if ($request->skpd_id) {
            $query->where('skpd_id', $request->skpd_id);
        }
        $data = $query->get();
        $data = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'nip' => $item->nip,
                'nama' => $item->nama,
                'pph_terutang' => $item->pph_terutang,
                'pph_thr' => $item->pph_thr
            ];
        })->sortByDesc(function ($item) {
            return $item['pph_terutang'] ?? 0;
        })->values()->toArray();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
