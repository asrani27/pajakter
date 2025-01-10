<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Models\Pajak;
use App\Models\BulanTahun;
use Illuminate\Http\Request;
use App\Imports\PegawaiImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PajakController extends Controller
{
    public function index()
    {
        $data = BulanTahun::orderBy('id', 'DESC')->get();
        return view('superadmin.pajak.index', compact('data'));
    }

    public function createBulanTahun()
    {
        return view('superadmin.pajak.create');
    }
    public function storeBulanTahun(Request $req)
    {
        $check = BulanTahun::where('bulan', $req->bulan)->where('tahun', $req->tahun)->first();
        if ($check == null) {
            BulanTahun::create($req->all());
            Session::flash('success', 'Berhasil Disimpan');
            return redirect('/superadmin/pajakter');
        } else {
            Session::flash('error', 'Bulan Dan Tahun Sudah Ada');
            $req->flash();
            return back();
        }
    }

    public function showSkpd($id)
    {
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::get();
        return view('superadmin.pajak.skpd', compact('skpd', 'id'));
    }

    public function showPajak($id, $skpd_id)
    {
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find($skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->get();
        return view('superadmin.pajak.hitung', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data'));
    }
    public function showBPJS($id, $skpd_id)
    {
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find($skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->get();
        return view('superadmin.pajak.bpjs', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data'));
    }

    public function resetPajak($id, $skpd_id)
    {
        Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->delete();
        return redirect()->back()->with('success', 'Berhasil Di Clear');
    }
    public function importPegawai(Request $req, $id, $skpd_id)
    {
        $validator = Validator::make($req->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Validasi gagal! Pastikan file yang diunggah sesuai format.');
            return redirect()->back();
        }

        try {

            Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->delete();

            Excel::import(new PegawaiImport($id, $skpd_id), $req->file('file'));

            return redirect()->back()->with('success', 'Data SKPD berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('fail', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }
}
