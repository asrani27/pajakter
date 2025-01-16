<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Models\Pajak;
use App\Models\BulanTahun;
use Illuminate\Http\Request;
use App\Imports\GajiTppImport;
use App\Imports\PegawaiImport;
use App\Imports\GajiBpjsImport;
use Illuminate\Support\Facades\DB;
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

    public function uploadGajiTPP(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Validasi gagal! Pastikan file yang diunggah sesuai format.');
            return redirect()->back();
        }

        try {

            Excel::import(new GajiTppImport($id), $req->file('file'));

            return redirect()->back()->with('success', 'Data SKPD berhasil diimport!');
        } catch (\Exception $e) {

            Session::flash('error', 'Gagal mengimport data: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function uploadGajiBPJS(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Validasi gagal! Pastikan file yang diunggah sesuai format.');
            return redirect()->back();
        }

        try {

            Excel::import(new GajiBpjsImport($id), $req->file('file'));

            return redirect()->back()->with('success', 'Data Gaji berhasil diimport!');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal mengimport data: ' . $e->getMessage());
            return redirect()->back();
        }
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
    public function tariktpp($id, $bulan, $tahun, $skpd_id)
    {
        $bulanMap = [
            'januari' => '01',
            'februari' => '02',
            'maret' => '03',
            'april' => '04',
            'mei' => '05',
            'juni' => '06',
            'juli' => '07',
            'agustus' => '08',
            'september' => '09',
            'oktober' => '10',
            'november' => '11',
            'desember' => '12',
        ];

        $no = $bulanMap[strtolower($bulan)] ?? null;

        if (!$no) {
            Session::flash('error', 'Bulan tidak valid');
            return back();
        }

        $rekapData = DB::connection('tpp')
            ->table('rekap_reguler')
            ->where('skpd_id', $skpd_id)
            ->where('bulan', $no)
            ->where('tahun', $tahun)
            ->pluck('jumlah_pembayaran', 'nip');


        $collection = collect($rekapData);
        $keys = $collection->keys();

        $list = Pajak::where('bulan_tahun_id', $id)->whereIn('nip', $keys->toArray())->update(['skpd_id' => $skpd_id]);

        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->get();
        if ($data->isEmpty()) {
            Session::flash('info', 'Tidak ada data pajak yang ditemukan');
            return back();
        }

        // Ambil semua NIP dari data pajak
        $nips = $data->pluck('nip')->toArray();


        // Ambil data rekap reguler dalam satu query
        $rekapData = DB::connection('tpp')
            ->table('rekap_reguler')
            ->whereIn('nip', $nips)
            ->where('bulan', $no)
            ->where('tahun', $tahun)
            ->pluck('jumlah_pembayaran', 'nip'); // Hasilkan array [nip => jumlah_pembayaran]

        // Update data pajak
        $updatedData = $data->map(function ($item) use ($rekapData) {
            $item->tpp = $rekapData[$item->nip] ?? 0; // Default ke 0 jika tidak ditemukan
            return $item->attributesToArray(); // Siapkan untuk batch update
        });

        // Lakukan batch update
        Pajak::upsert(
            $updatedData->map(function ($item) {
                $pajakInstance = new Pajak($item);

                $item['pph_terutang'] = $pajakInstance->pph_terutang;

                $item['created_at'] = now()->format('Y-m-d H:i:s'); // Format datetime
                $item['updated_at'] = now()->format('Y-m-d H:i:s');
                return $item;
            })->toArray(),
            ['id'],
            ['tpp', 'pph_terutang', 'updated_at']
        );

        Session::flash('success', 'Data TPP berhasil ditarik');
        return back();
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
        Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->update(['skpd_id' => null]);
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
