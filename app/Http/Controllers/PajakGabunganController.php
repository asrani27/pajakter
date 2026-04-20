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
        $data = $query->get()->select('id', 'nip', 'nama', 'pph_terutang', 'pagu')->sortByDesc('pagu');
        //$data = $query->select('id', 'nip', 'nama', 'pph_terutang')->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
