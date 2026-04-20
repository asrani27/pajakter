<?php

namespace App\Http\Controllers;

use App\Imports\ThrImport;
use App\Models\BulanTahun;
use App\Models\Pajak;
use App\Models\Skpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

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
    public function uploadTHR(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Validasi gagal! Pastikan file yang diunggah sesuai format.');
            return redirect()->back();
        }

        try {

            Excel::import(new ThrImport($id), $req->file('file'));

            return redirect()->back()->with('success', 'Data THR berhasil diimport!');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal mengimport data: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function exportPdf(Request $request)
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

        $total_pajak = collect($data)->sum('pph_terutang');
        $total_thr = collect($data)->sum('pph_thr');

        $bulanTahun = $request->bulan_tahun_id ? BulanTahun::find($request->bulan_tahun_id) : null;
        $skpd = $request->skpd_id ? Skpd::find($request->skpd_id) : null;

        $pdf = Pdf::loadView('superadmin.pajak.gabungan_pdf', [
            'data' => $data,
            'total_pajak' => $total_pajak,
            'total_thr' => $total_thr,
            'bulan_tahun' => $bulanTahun,
            'skpd' => $skpd
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('laporan_pajak_gabungan.pdf');
    }
}
