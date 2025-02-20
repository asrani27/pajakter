<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Models\Pajak;
use App\Models\BulanTahun;
use Illuminate\Http\Request;
use App\Imports\GajiTppImport;
use App\Imports\PegawaiImport;
use App\Imports\TppGuruImport;
use App\Imports\GajiBpjsImport;
use App\Imports\GajiPppkImport;
use App\Imports\TppGuruSDImport;
use App\Imports\TppGuruSMPImport;
use Illuminate\Support\Facades\DB;
use App\Imports\TppGuruTeknisImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PajakController extends Controller
{
    public function index()
    {
        $data = BulanTahun::orderBy('id', 'DESC')->get();
        return view('superadmin.pajak.index', compact('data'));
    }

    public function pppkPajak()
    {
        $data = BulanTahun::orderBy('id', 'DESC')->get();
        return view('superadmin.pajak.index', compact('data'));
    }
    public function showPppkBpjs($id)
    {
        $bulanTahun = BulanTahun::find($id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('status_pegawai', 'PPPK')->get()->sortByDesc('jumlah_penghasilan');
        return view('superadmin.pajak.pppk.bpjs', compact('id', 'bulanTahun', 'data'));
    }
    public function showPppkPajak($id)
    {
        $bulanTahun = BulanTahun::find($id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('status_pegawai', 'PPPK')->get()->sortByDesc('total_penghasilan');

        return view('superadmin.pajak.pppk.hitung', compact('id', 'bulanTahun', 'data'));
    }
    public function pppkBpjs()
    {
        $data = BulanTahun::orderBy('id', 'DESC')->get();
        return view('superadmin.pajak.index', compact('data'));
    }


    public function uploadTPPGuru(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Validasi gagal! Pastikan file yang diunggah sesuai format.');
            return redirect()->back();
        }

        try {

            if ($req->button == 'sheet1') {
                $data = Excel::import(new TppGuruImport($id), $req->file('file'));
            }
            if ($req->button == 'sheet2') {
                $data = Excel::import(new TppGuruSDImport($id), $req->file('file'));
            }
            if ($req->button == 'sheet3') {

                $data = Excel::import(new TppGuruSMPImport($id), $req->file('file'));
            }
            if ($req->button == 'sheet4') {
                $data = Excel::import(new TppGuruTeknisImport($id), $req->file('file'));
            }

            return redirect()->back()->with('success', 'berhasil diimport!');
        } catch (\Exception $e) {

            Session::flash('error', 'Gagal mengimport data: ' . $e->getMessage());
            return redirect()->back();
        }
    }
    public function uploadGajiPPPK(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Validasi gagal! Pastikan file yang diunggah sesuai format.');
            return redirect()->back();
        }

        try {

            Excel::import(new GajiPppkImport($id), $req->file('file'));

            return redirect()->back()->with('success', 'berhasil diimport!');
        } catch (\Exception $e) {

            Session::flash('error', 'Gagal mengimport data: ' . $e->getMessage());
            return redirect()->back();
        }
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

            return redirect()->back()->with('success', 'Data berhasil diimport!');
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

        // Ambil pagu juga
        $nilaiTppData = DB::connection('tpp')
            ->table('rekap_reguler')
            ->where('skpd_id', $skpd_id)
            ->where('bulan', $no)
            ->where('tahun', $tahun)
            ->pluck('pagu', 'nip');

        $collection = collect($rekapData);
        $keys = $collection->keys();
        $arrayString = array_map(function ($item) {
            return (string)$item; // Mengubah setiap item menjadi string
        }, $keys->toArray());

        $existingNips = Pajak::where('bulan_tahun_id', $id)
            ->whereIn('nip', $arrayString)
            ->pluck('nip')
            ->toArray();

        // Identifikasi NIP yang tidak ada di tabel Pajak
        $missingNips = array_diff($arrayString, $existingNips);

        //dd($missingNips, $arrayString);
        // Jika ada NIP yang tidak ditemukan, tambahkan ke tabel Pajak
        foreach ($missingNips as $missingNip) {
            Pajak::create([
                'bulan_tahun_id' => $id,
                'nip' => $missingNip,
                'nama' => DB::connection('tpp')
                    ->table('rekap_reguler')->where('nip', $missingNip)->first()->nama,
                'skpd_id' => $skpd_id,
                'jumlah_pembayaran' => $rekapData[$missingNip] ?? 0, // Default nilai jika tidak ada di $rekapData
                'pagu' => $nilaiTppData[$missingNip] ?? 0, // Menambahkan pagu
            ]);
        }


        $list = Pajak::where('bulan_tahun_id', $id)->whereIn('nip', $arrayString)->update(['skpd_id' => $skpd_id]);


        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('status_pegawai', null)->get();
        if ($data->isEmpty()) {
            Session::flash('info', 'Tidak ada data pajak yang ditemukan');
            return back();
        }

        // Ambil semua NIP dari data pajak
        $nips = $data->pluck('nip')->toArray();

        $rekapDataPlt = DB::connection('tpp')
            ->table('rekap_plt')
            ->where('skpd_id', $skpd_id)
            ->where('bulan', $no)
            ->where('tahun', $tahun)
            ->pluck('jumlah_pembayaran', 'nip');

        // Ambil data rekap reguler dalam satu query
        $rekapData = DB::connection('tpp')
            ->table('rekap_reguler')
            ->whereIn('nip', $nips)
            ->where('bulan', $no)
            ->where('tahun', $tahun)
            ->pluck('jumlah_pembayaran', 'nip'); // Hasilkan array [nip => jumlah_pembayaran]
        // Ambil pagu
        $nilaiTppData = DB::connection('tpp')
            ->table('rekap_reguler')
            ->whereIn('nip', $nips)
            ->where('bulan', $no)
            ->where('tahun', $tahun)
            ->pluck('pagu', 'nip');

        // Update data pajak
        $updatedData = $data->map(function ($item) use ($rekapData, $nilaiTppData, $rekapDataPlt) {

            $item->bpjs_satu_persen = $item->tpp_satu_persen;
            $item->bpjs_empat_persen = $item->tpp_empat_persen;
            $item->tpp = $rekapData[$item->nip] ?? 0; // Default ke 0 jika tidak ditemukan
            $item->tpp_plt = $rekapDataPlt[$item->nip] ?? 0; // Default ke 0 jika tidak ditemukan
            $item->pagu = $nilaiTppData[$item->nip] ?? 0;
            return $item->attributesToArray(); // Siapkan untuk batch update
        });

        // Lakukan batch update
        Pajak::upsert(
            $updatedData->map(function ($item) {
                $pajakInstance = new Pajak($item);

                $item['pph_terutang'] = $pajakInstance->pph_terutang;

                $item['created_at'] = now()->format('Y-m-d H:i:s'); // Format datetime
                $item['updated_at'] = now()->format('Y-m-d H:i:s');
                $item['bpjs_satu_persen'] = $item['bpjs_satu_persen'];
                $item['bpjs_empat_persen'] = $item['bpjs_empat_persen'];
                $item['pagu'] = $item['pagu'];
                return $item;
            })->toArray(),
            ['id'],
            ['tpp', 'pagu',  'bpjs_satu_persen', 'bpjs_empat_persen', 'pph_terutang', 'updated_at']
        );
        $updatedData2 = $data->map(function ($item) use ($rekapDataPlt) {
            $tpp_plt = $rekapDataPlt[$item->nip] ?? 0;

            $item->tpp = $item->tpp + $tpp_plt;
            return $item->save(); // Siapkan untuk batch update
        });
        Session::flash('success', 'Data TPP berhasil ditarik');
        return back();
    }
    public function showPajak($id, $skpd_id)
    {
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find($skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('status_pegawai', null)->get()->sortByDesc('total_penghasilan');
        return view('superadmin.pajak.hitung', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data'));
    }

    public function showPajakGuru($id, $skpd_id)
    {
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find($skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('sheet', '1')->get()->sortByDesc('total_penghasilan');
        return view('superadmin.pajak.guru.sheet1', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data'));
    }
    public function showBpjsGuru($id, $skpd_id)
    {
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find($skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('sheet', '1')->get()->sortByDesc('total_penghasilan');
        $nosheet = 1;
        return view('superadmin.pajak.guru.bpjs', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data', 'nosheet'));
    }
    public function showPajakGuruSD($id, $skpd_id)
    {
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find($skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('sheet', '2')->get()->sortByDesc('total_penghasilan');

        return view('superadmin.pajak.guru.sheet2', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data'));
    }
    public function showBpjsGuruSD($id, $skpd_id)
    {
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find($skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('sheet', '2')->get()->sortByDesc('total_penghasilan');
        $nosheet = 2;
        return view('superadmin.pajak.guru.bpjs', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data', 'nosheet'));
    }
    public function showPajakGuruSMP($id, $skpd_id)
    {
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find($skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('sheet', '3')->get()->sortByDesc('total_penghasilan');

        return view('superadmin.pajak.guru.sheet3', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data'));
    }
    public function showBpjsGuruSMP($id, $skpd_id)
    {
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find($skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('sheet', '3')->get()->sortByDesc('total_penghasilan');
        $nosheet = 3;
        return view('superadmin.pajak.guru.bpjs', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data', 'nosheet'));
    }
    public function showPajakGuruTeknis($id, $skpd_id)
    {
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find($skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('sheet', '4')->get()->sortByDesc('total_penghasilan');
        return view('superadmin.pajak.guru.sheet4', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data'));
    }
    public function showBpjsGuruTeknis($id, $skpd_id)
    {
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find($skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('sheet', '4')->get()->sortByDesc('total_penghasilan');
        $nosheet = 4;
        return view('superadmin.pajak.guru.bpjs', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data', 'nosheet'));
    }
    public function showBPJS($id, $skpd_id)
    {
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find($skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('status_pegawai', null)->get()->sortByDesc('jumlah_penghasilan');
        return view('superadmin.pajak.bpjs', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data'));
    }

    public function resetPPPK($id)
    {
        Pajak::where('bulan_tahun_id', $id)->where('status_pegawai', 'PPPK')->delete();
        return redirect()->back()->with('success', 'Berhasil Di Clear');
    }

    public function resetPajakGuruSD($id, $skpd_id)
    {
        Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('sheet', 2)->update(['skpd_id' => null]);
        return redirect()->back()->with('success', 'Berhasil Di Clear');
    }
    public function resetPajakGuruSMP($id, $skpd_id)
    {
        Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('sheet', 3)->update(['skpd_id' => null]);
        return redirect()->back()->with('success', 'Berhasil Di Clear');
    }
    public function resetPajakGuruTeknis($id, $skpd_id)
    {
        Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('sheet', 4)->update(['skpd_id' => null]);
        return redirect()->back()->with('success', 'Berhasil Di Clear');
    }
    public function resetPajakGuru($id, $skpd_id)
    {
        Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('sheet', 1)->update(['skpd_id' => null]);
        return redirect()->back()->with('success', 'Berhasil Di Clear');
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

    public function exportBpjsPPPK($id)
    {
        dd($id);
    }

    public function exportPajakPPPK($id)
    {
        $templatePath = public_path('excel/pajak.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        $bulanTahun = BulanTahun::find($id);
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->setCellValue('A1', 'PPPK');
        $sheet->setCellValue('A2', 'PERIODE : ' . $bulanTahun->bulan . ' ' . $bulanTahun->tahun);

        // Menambahkan format: Membuat teks tebal dan memusatkan teks
        $sheet->getStyle('A1:A2')->getFont()->setBold(true);

        $pajaks = Pajak::where('bulan_tahun_id', $id)->where('status_pegawai', 'PPPK')->get()->sortByDesc('total_penghasilan')->values();
        if ($pajaks->count() === 0) {
            Session::flash('info', 'Tidak ada Data Untuk Di Export');
            return redirect()->back();
        }
        $rowStart = 6; // Mulai dari baris kedua (misalnya)
        $rowEnd = $rowStart + count($pajaks) - 1; // Baris akhir berdasarkan jumlah data


        $no = 1;
        foreach ($pajaks as $index => $pajak) {
            $row = $rowStart + $index;
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, "'" . $pajak->nip);
            $sheet->setCellValue('C' . $row, $pajak->nama);
            $sheet->setCellValue('D' . $row, $pajak->ptkp);
            $sheet->setCellValue('E' . $row, $pajak->gaji);
            $sheet->setCellValue('F' . $row, $pajak->tpp);
            $sheet->setCellValue('G' . $row, $pajak->total_penghasilan);
            $sheet->setCellValue('H' . $row, $pajak->kelompok);
            $sheet->setCellValue('I' . $row, $pajak->tarif);
            $sheet->setCellValue('J' . $row, $pajak->pph_penghasilan);
            $sheet->setCellValue('K' . $row, $pajak->pph_gaji);
            $sheet->setCellValue('L' . $row, $pajak->pph_terutang);

            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');

            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        // Menambahkan SUM di bawah setiap kolom yang diinginkan
        $sheet->setCellValue('E' . ($row), '=SUM(E' . $rowStart . ':E' . ($row - 1) . ')');
        $sheet->setCellValue('F' . ($row), '=SUM(F' . $rowStart . ':F' . ($row - 1) . ')');
        $sheet->setCellValue('G' . ($row), '=SUM(G' . $rowStart . ':G' . ($row - 1) . ')');
        $sheet->setCellValue('J' . ($row), '=SUM(J' . $rowStart . ':J' . ($row - 1) . ')');
        $sheet->setCellValue('K' . ($row), '=SUM(K' . $rowStart . ':K' . ($row - 1) . ')');
        $sheet->setCellValue('L' . ($row), '=SUM(L' . $rowStart . ':L' . ($row - 1) . ')');

        // Format untuk SUM (bold dan rata tengah)
        $sheet->getStyle('E' . ($row) . ':L' . ($row))->getFont()->setBold(true);
        $sheet->getStyle('E' . ($row) . ':L' . ($row))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
        // Menambahkan warna latar belakang pada baris SUM
        $sheet->getStyle('E' . ($row) . ':L' . ($row))
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFF00'); // Menggunakan warna kuning (FFFF00)
        // Atur auto size untuk kolom dari A hingga D
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Menambahkan border untuk seluruh data yang diisi
        $cellRange = 'A' . $rowStart . ':L' . $rowEnd;  // Sesuaikan dengan kolom yang digunakan

        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setColor(new Color(Color::COLOR_BLACK));

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Pajak_PPPK_Report_' . date('YmdHis') . '.xlsx';
        $filePath = storage_path('app/public/reports/' . $fileName);

        $writer->save($filePath);

        return response()->download($filePath);
    }
    public function exportPajakSKPD($id, $skpd_id)
    {
        $templatePath = public_path('excel/pajak.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        $skpd = Skpd::find($skpd_id);

        $bulanTahun = BulanTahun::find($id);

        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->setCellValue('A1', strtoupper($skpd->nama));
        $sheet->setCellValue('A2', 'PERIODE : ' . $bulanTahun->bulan . ' ' . $bulanTahun->tahun);

        // Menambahkan format: Membuat teks tebal dan memusatkan teks
        $sheet->getStyle('A1:A2')->getFont()->setBold(true);

        $pajaks = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('status_pegawai', null)->get()->sortByDesc('total_penghasilan')->values();
        if ($pajaks->count() === 0) {
            Session::flash('info', 'Tidak ada Data Untuk Di Export');
            return redirect()->back();
        }
        $rowStart = 6; // Mulai dari baris kedua (misalnya)
        $rowEnd = $rowStart + count($pajaks) - 1; // Baris akhir berdasarkan jumlah data


        $no = 1;
        foreach ($pajaks as $index => $pajak) {
            $row = $rowStart + $index;
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, "'" . $pajak->nip);
            $sheet->setCellValue('C' . $row, $pajak->nama);
            $sheet->setCellValue('D' . $row, $pajak->ptkp);
            $sheet->setCellValue('E' . $row, $pajak->gaji);
            $sheet->setCellValue('F' . $row, $pajak->tpp);
            $sheet->setCellValue('G' . $row, $pajak->total_penghasilan);
            $sheet->setCellValue('H' . $row, $pajak->kelompok);
            $sheet->setCellValue('I' . $row, $pajak->tarif);
            $sheet->setCellValue('J' . $row, $pajak->pph_penghasilan);
            $sheet->setCellValue('K' . $row, $pajak->pph_gaji);
            $sheet->setCellValue('L' . $row, $pajak->pph_terutang);

            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');

            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        // Menambahkan SUM di bawah setiap kolom yang diinginkan
        $sheet->setCellValue('E' . ($row), '=SUM(E' . $rowStart . ':E' . ($row - 1) . ')');
        $sheet->setCellValue('F' . ($row), '=SUM(F' . $rowStart . ':F' . ($row - 1) . ')');
        $sheet->setCellValue('G' . ($row), '=SUM(G' . $rowStart . ':G' . ($row - 1) . ')');
        $sheet->setCellValue('J' . ($row), '=SUM(J' . $rowStart . ':J' . ($row - 1) . ')');
        $sheet->setCellValue('K' . ($row), '=SUM(K' . $rowStart . ':K' . ($row - 1) . ')');
        $sheet->setCellValue('L' . ($row), '=SUM(L' . $rowStart . ':L' . ($row - 1) . ')');

        // Format untuk SUM (bold dan rata tengah)
        $sheet->getStyle('E' . ($row) . ':L' . ($row))->getFont()->setBold(true);
        $sheet->getStyle('E' . ($row) . ':L' . ($row))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
        // Menambahkan warna latar belakang pada baris SUM
        $sheet->getStyle('E' . ($row) . ':L' . ($row))
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFF00'); // Menggunakan warna kuning (FFFF00)
        // Atur auto size untuk kolom dari A hingga D
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Menambahkan border untuk seluruh data yang diisi
        $cellRange = 'A' . $rowStart . ':L' . $rowEnd;  // Sesuaikan dengan kolom yang digunakan

        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setColor(new Color(Color::COLOR_BLACK));

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Pajak_Report_' . date('YmdHis') . '.xlsx';
        $filePath = storage_path('app/public/reports/' . $fileName);

        $writer->save($filePath);

        return response()->download($filePath);
    }
    public function exportBpjsSKPD($id, $skpd_id)
    {

        $templatePath = public_path('excel/bpjs.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        $skpd = Skpd::find($skpd_id);

        $bulanTahun = BulanTahun::find($id);

        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->setCellValue('A1', strtoupper($skpd->nama));
        $sheet->setCellValue('A2', 'PERIODE : ' . $bulanTahun->bulan . ' ' . $bulanTahun->tahun);

        // Menambahkan format: Membuat teks tebal dan memusatkan teks
        $sheet->getStyle('A1:A2')->getFont()->setBold(true);
        //dd($skpd);
        $bpjs = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('status_pegawai', null)->get()->sortByDesc('total_penghasilan')->values();
        if ($bpjs->count() === 0) {
            Session::flash('info', 'Tidak ada Data Untuk Di Export');
            return redirect()->back();
        }
        $rowStart = 6; // Mulai dari baris kedua (misalnya)
        $rowEnd = $rowStart + count($bpjs) - 1; // Baris akhir berdasarkan jumlah data


        $no = 1;
        foreach ($bpjs as $index => $bpj) {
            $row = $rowStart + $index;
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, "'" . $bpj->nip);
            $sheet->setCellValue('C' . $row, $bpj->nama);
            $sheet->setCellValue('D' . $row, $bpj->gapok);
            $sheet->setCellValue('E' . $row, $bpj->tjk);
            $sheet->setCellValue('F' . $row, $bpj->tjb);
            $sheet->setCellValue('G' . $row, $bpj->tjf);
            $sheet->setCellValue('H' . $row, $bpj->tjfu);
            $sheet->setCellValue('I' . $row, $bpj->jumlah_gaji);
            $sheet->setCellValue('J' . $row, $bpj->pagu);
            $sheet->setCellValue('K' . $row, 0);
            $sheet->setCellValue('L' . $row, 0);
            $sheet->setCellValue('M' . $row, 0);
            $sheet->setCellValue('N' . $row, $bpj->jumlah_tunjangan);
            $sheet->setCellValue('O' . $row, $bpj->jumlah_penghasilan);
            $sheet->setCellValue('P' . $row, $bpj->iuran_satu_persen);
            $sheet->setCellValue('Q' . $row, $bpj->iuran_empat_persen);
            $sheet->setCellValue('R' . $row, $bpj->gaji_satu_persen);
            $sheet->setCellValue('S' . $row, $bpj->gaji_empat_persen);
            $sheet->setCellValue('T' . $row, $bpj->tpp_satu_persen);
            $sheet->setCellValue('U' . $row, $bpj->tpp_empat_persen);
            // $sheet->setCellValue('F' . $row, $pajak->tpp);
            // $sheet->setCellValue('G' . $row, $pajak->total_penghasilan);
            // $sheet->setCellValue('H' . $row, $pajak->kelompok);
            // $sheet->setCellValue('I' . $row, $pajak->tarif);
            // $sheet->setCellValue('J' . $row, $pajak->pph_penghasilan);
            // $sheet->setCellValue('K' . $row, $pajak->pph_gaji);
            // $sheet->setCellValue('L' . $row, $pajak->pph_terutang);

            $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('M' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('N' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('O' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('P' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('Q' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('R' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('S' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('T' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('U' . $row)->getNumberFormat()->setFormatCode('#,##0');

            // $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            // $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        // Menambahkan SUM di bawah setiap kolom yang diinginkan
        $sheet->setCellValue('D' . ($row), '=SUM(D' . $rowStart . ':D' . ($row - 1) . ')');
        $sheet->setCellValue('E' . ($row), '=SUM(E' . $rowStart . ':E' . ($row - 1) . ')');
        $sheet->setCellValue('F' . ($row), '=SUM(F' . $rowStart . ':F' . ($row - 1) . ')');
        $sheet->setCellValue('G' . ($row), '=SUM(G' . $rowStart . ':G' . ($row - 1) . ')');
        $sheet->setCellValue('J' . ($row), '=SUM(J' . $rowStart . ':J' . ($row - 1) . ')');
        $sheet->setCellValue('K' . ($row), '=SUM(K' . $rowStart . ':K' . ($row - 1) . ')');
        $sheet->setCellValue('L' . ($row), '=SUM(L' . $rowStart . ':L' . ($row - 1) . ')');
        $sheet->setCellValue('M' . ($row), '=SUM(M' . $rowStart . ':M' . ($row - 1) . ')');
        $sheet->setCellValue('N' . ($row), '=SUM(N' . $rowStart . ':N' . ($row - 1) . ')');
        $sheet->setCellValue('O' . ($row), '=SUM(O' . $rowStart . ':O' . ($row - 1) . ')');
        $sheet->setCellValue('P' . ($row), '=SUM(P' . $rowStart . ':P' . ($row - 1) . ')');
        $sheet->setCellValue('Q' . ($row), '=SUM(Q' . $rowStart . ':Q' . ($row - 1) . ')');
        $sheet->setCellValue('R' . ($row), '=SUM(R' . $rowStart . ':R' . ($row - 1) . ')');
        $sheet->setCellValue('S' . ($row), '=SUM(S' . $rowStart . ':S' . ($row - 1) . ')');
        $sheet->setCellValue('T' . ($row), '=SUM(T' . $rowStart . ':T' . ($row - 1) . ')');
        $sheet->setCellValue('U' . ($row), '=SUM(U' . $rowStart . ':U' . ($row - 1) . ')');

        // Format untuk SUM (bold dan rata tengah)
        $sheet->getStyle('D' . ($row) . ':U' . ($row))->getFont()->setBold(true);
        $sheet->getStyle('D' . ($row) . ':U' . ($row))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('M' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('N' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('O' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('P' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('Q' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('R' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('S' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('T' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('U' . $row)->getNumberFormat()->setFormatCode('#,##0');
        // Menambahkan warna latar belakang pada baris SUM
        $sheet->getStyle('D' . ($row) . ':U' . ($row))
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFF00'); // Menggunakan warna kuning (FFFF00)
        // Atur auto size untuk kolom dari A hingga D
        foreach (range('A', 'U') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Menambahkan border untuk seluruh data yang diisi
        $cellRange = 'A' . $rowStart . ':U' . $rowEnd;  // Sesuaikan dengan kolom yang digunakan

        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setColor(new Color(Color::COLOR_BLACK));

        $writer = new Xlsx($spreadsheet);
        $fileName = 'BPJS_Report_' . date('YmdHis') . '.xlsx';
        $filePath = storage_path('app/public/reports/' . $fileName);

        $writer->save($filePath);


        return response()->download($filePath);
    }
    public function exportPajakSKPDPPPK($id, $skpd_id)
    {
        $templatePath = public_path('excel/pajak.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        $skpd = Skpd::find($skpd_id);

        $bulanTahun = BulanTahun::find($id);

        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->setCellValue('A1', strtoupper($skpd->nama));
        $sheet->setCellValue('A2', 'PERIODE : ' . $bulanTahun->bulan . ' ' . $bulanTahun->tahun);

        // Menambahkan format: Membuat teks tebal dan memusatkan teks
        $sheet->getStyle('A1:A2')->getFont()->setBold(true);

        $pajaks = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('status_pegawai', 'PPPK')->get()->sortByDesc('total_penghasilan')->values();
        if ($pajaks->count() === 0) {
            Session::flash('info', 'Tidak ada Data Untuk Di Export');
            return redirect()->back();
        }
        $rowStart = 6; // Mulai dari baris kedua (misalnya)
        $rowEnd = $rowStart + count($pajaks) - 1; // Baris akhir berdasarkan jumlah data


        $no = 1;
        foreach ($pajaks as $index => $pajak) {
            $row = $rowStart + $index;
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, "'" . $pajak->nip);
            $sheet->setCellValue('C' . $row, $pajak->nama);
            $sheet->setCellValue('D' . $row, $pajak->ptkp);
            $sheet->setCellValue('E' . $row, $pajak->gaji);
            $sheet->setCellValue('F' . $row, $pajak->tpp);
            $sheet->setCellValue('G' . $row, $pajak->total_penghasilan);
            $sheet->setCellValue('H' . $row, $pajak->kelompok);
            $sheet->setCellValue('I' . $row, $pajak->tarif);
            $sheet->setCellValue('J' . $row, $pajak->pph_penghasilan);
            $sheet->setCellValue('K' . $row, $pajak->pph_gaji);
            $sheet->setCellValue('L' . $row, $pajak->pph_terutang);

            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');

            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        // Menambahkan SUM di bawah setiap kolom yang diinginkan
        $sheet->setCellValue('E' . ($row), '=SUM(E' . $rowStart . ':E' . ($row - 1) . ')');
        $sheet->setCellValue('F' . ($row), '=SUM(F' . $rowStart . ':F' . ($row - 1) . ')');
        $sheet->setCellValue('G' . ($row), '=SUM(G' . $rowStart . ':G' . ($row - 1) . ')');
        $sheet->setCellValue('J' . ($row), '=SUM(J' . $rowStart . ':J' . ($row - 1) . ')');
        $sheet->setCellValue('K' . ($row), '=SUM(K' . $rowStart . ':K' . ($row - 1) . ')');
        $sheet->setCellValue('L' . ($row), '=SUM(L' . $rowStart . ':L' . ($row - 1) . ')');

        // Format untuk SUM (bold dan rata tengah)
        $sheet->getStyle('E' . ($row) . ':L' . ($row))->getFont()->setBold(true);
        $sheet->getStyle('E' . ($row) . ':L' . ($row))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
        // Menambahkan warna latar belakang pada baris SUM
        $sheet->getStyle('E' . ($row) . ':L' . ($row))
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFF00'); // Menggunakan warna kuning (FFFF00)
        // Atur auto size untuk kolom dari A hingga D
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Menambahkan border untuk seluruh data yang diisi
        $cellRange = 'A' . $rowStart . ':L' . $rowEnd;  // Sesuaikan dengan kolom yang digunakan

        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setColor(new Color(Color::COLOR_BLACK));

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Pajak_Report_' . date('YmdHis') . '.xlsx';
        $filePath = storage_path('app/public/reports/' . $fileName);

        $writer->save($filePath);

        return response()->download($filePath);
    }
    public function exportBpjsSKPDPPPK($id, $skpd_id)
    {

        $templatePath = public_path('excel/bpjs.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        $skpd = Skpd::find($skpd_id);

        $bulanTahun = BulanTahun::find($id);

        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->setCellValue('A1', strtoupper($skpd->nama));
        $sheet->setCellValue('A2', 'PERIODE : ' . $bulanTahun->bulan . ' ' . $bulanTahun->tahun);

        // Menambahkan format: Membuat teks tebal dan memusatkan teks
        $sheet->getStyle('A1:A2')->getFont()->setBold(true);
        //dd($skpd);
        $bpjs = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('status_pegawai', 'PPPK')->get()->sortByDesc('total_penghasilan')->values();
        if ($bpjs->count() === 0) {
            Session::flash('info', 'Tidak ada Data Untuk Di Export');
            return redirect()->back();
        }
        $rowStart = 6; // Mulai dari baris kedua (misalnya)
        $rowEnd = $rowStart + count($bpjs) - 1; // Baris akhir berdasarkan jumlah data


        $no = 1;
        foreach ($bpjs as $index => $bpj) {
            $row = $rowStart + $index;
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, "'" . $bpj->nip);
            $sheet->setCellValue('C' . $row, $bpj->nama);
            $sheet->setCellValue('D' . $row, $bpj->gapok);
            $sheet->setCellValue('E' . $row, $bpj->tjk);
            $sheet->setCellValue('F' . $row, $bpj->tjb);
            $sheet->setCellValue('G' . $row, $bpj->tjf);
            $sheet->setCellValue('H' . $row, $bpj->tjfu);
            $sheet->setCellValue('I' . $row, $bpj->jumlah_gaji);
            $sheet->setCellValue('J' . $row, $bpj->pagu);
            $sheet->setCellValue('K' . $row, 0);
            $sheet->setCellValue('L' . $row, 0);
            $sheet->setCellValue('M' . $row, 0);
            $sheet->setCellValue('N' . $row, $bpj->jumlah_tunjangan);
            $sheet->setCellValue('O' . $row, $bpj->jumlah_penghasilan);
            $sheet->setCellValue('P' . $row, $bpj->iuran_satu_persen);
            $sheet->setCellValue('Q' . $row, $bpj->iuran_empat_persen);
            $sheet->setCellValue('R' . $row, $bpj->gaji_satu_persen);
            $sheet->setCellValue('S' . $row, $bpj->gaji_empat_persen);
            $sheet->setCellValue('T' . $row, $bpj->tpp_satu_persen);
            $sheet->setCellValue('U' . $row, $bpj->tpp_empat_persen);
            // $sheet->setCellValue('F' . $row, $pajak->tpp);
            // $sheet->setCellValue('G' . $row, $pajak->total_penghasilan);
            // $sheet->setCellValue('H' . $row, $pajak->kelompok);
            // $sheet->setCellValue('I' . $row, $pajak->tarif);
            // $sheet->setCellValue('J' . $row, $pajak->pph_penghasilan);
            // $sheet->setCellValue('K' . $row, $pajak->pph_gaji);
            // $sheet->setCellValue('L' . $row, $pajak->pph_terutang);

            $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('M' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('N' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('O' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('P' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('Q' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('R' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('S' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('T' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('U' . $row)->getNumberFormat()->setFormatCode('#,##0');

            // $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            // $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        // Menambahkan SUM di bawah setiap kolom yang diinginkan
        $sheet->setCellValue('D' . ($row), '=SUM(D' . $rowStart . ':D' . ($row - 1) . ')');
        $sheet->setCellValue('E' . ($row), '=SUM(E' . $rowStart . ':E' . ($row - 1) . ')');
        $sheet->setCellValue('F' . ($row), '=SUM(F' . $rowStart . ':F' . ($row - 1) . ')');
        $sheet->setCellValue('G' . ($row), '=SUM(G' . $rowStart . ':G' . ($row - 1) . ')');
        $sheet->setCellValue('J' . ($row), '=SUM(J' . $rowStart . ':J' . ($row - 1) . ')');
        $sheet->setCellValue('K' . ($row), '=SUM(K' . $rowStart . ':K' . ($row - 1) . ')');
        $sheet->setCellValue('L' . ($row), '=SUM(L' . $rowStart . ':L' . ($row - 1) . ')');
        $sheet->setCellValue('M' . ($row), '=SUM(M' . $rowStart . ':M' . ($row - 1) . ')');
        $sheet->setCellValue('N' . ($row), '=SUM(N' . $rowStart . ':N' . ($row - 1) . ')');
        $sheet->setCellValue('O' . ($row), '=SUM(O' . $rowStart . ':O' . ($row - 1) . ')');
        $sheet->setCellValue('P' . ($row), '=SUM(P' . $rowStart . ':P' . ($row - 1) . ')');
        $sheet->setCellValue('Q' . ($row), '=SUM(Q' . $rowStart . ':Q' . ($row - 1) . ')');
        $sheet->setCellValue('R' . ($row), '=SUM(R' . $rowStart . ':R' . ($row - 1) . ')');
        $sheet->setCellValue('S' . ($row), '=SUM(S' . $rowStart . ':S' . ($row - 1) . ')');
        $sheet->setCellValue('T' . ($row), '=SUM(T' . $rowStart . ':T' . ($row - 1) . ')');
        $sheet->setCellValue('U' . ($row), '=SUM(U' . $rowStart . ':U' . ($row - 1) . ')');

        // Format untuk SUM (bold dan rata tengah)
        $sheet->getStyle('D' . ($row) . ':U' . ($row))->getFont()->setBold(true);
        $sheet->getStyle('D' . ($row) . ':U' . ($row))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('M' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('N' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('O' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('P' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('Q' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('R' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('S' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('T' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('U' . $row)->getNumberFormat()->setFormatCode('#,##0');
        // Menambahkan warna latar belakang pada baris SUM
        $sheet->getStyle('D' . ($row) . ':U' . ($row))
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFF00'); // Menggunakan warna kuning (FFFF00)
        // Atur auto size untuk kolom dari A hingga D
        foreach (range('A', 'U') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Menambahkan border untuk seluruh data yang diisi
        $cellRange = 'A' . $rowStart . ':U' . $rowEnd;  // Sesuaikan dengan kolom yang digunakan

        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setColor(new Color(Color::COLOR_BLACK));

        $writer = new Xlsx($spreadsheet);
        $fileName = 'BPJS_Report_' . date('YmdHis') . '.xlsx';
        $filePath = storage_path('app/public/reports/' . $fileName);

        $writer->save($filePath);


        return response()->download($filePath);
    }
    public function exportPajakSheet($id, $skpd_id, $nosheet)
    {

        $templatePath = public_path('excel/pajak.xlsx');

        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        $skpd = Skpd::find($skpd_id);

        $bulanTahun = BulanTahun::find($id);

        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->setCellValue('A1', strtoupper($skpd->nama));
        $sheet->setCellValue('A2', 'PERIODE : ' . $bulanTahun->bulan . ' ' . $bulanTahun->tahun);

        // Menambahkan format: Membuat teks tebal dan memusatkan teks
        $sheet->getStyle('A1:A2')->getFont()->setBold(true);

        $pajaks = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('sheet', $nosheet)->get()->sortByDesc('total_penghasilan')->values();
        if ($pajaks->count() === 0) {
            Session::flash('info', 'Tidak ada Data Untuk Di Export');
            return redirect()->back();
        }
        $rowStart = 6; // Mulai dari baris kedua (misalnya)
        $rowEnd = $rowStart + count($pajaks) - 1; // Baris akhir berdasarkan jumlah data


        $no = 1;
        foreach ($pajaks as $index => $pajak) {
            $row = $rowStart + $index;
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, "'" . $pajak->nip);
            $sheet->setCellValue('C' . $row, $pajak->nama);
            $sheet->setCellValue('D' . $row, $pajak->ptkp);
            $sheet->setCellValue('E' . $row, $pajak->gaji);
            $sheet->setCellValue('F' . $row, $pajak->tpp);
            $sheet->setCellValue('G' . $row, $pajak->total_penghasilan);
            $sheet->setCellValue('H' . $row, $pajak->kelompok);
            $sheet->setCellValue('I' . $row, $pajak->tarif);
            $sheet->setCellValue('J' . $row, $pajak->pph_penghasilan);
            $sheet->setCellValue('K' . $row, $pajak->pph_gaji);
            $sheet->setCellValue('L' . $row, $pajak->pph_terutang);

            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');

            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        // Menambahkan SUM di bawah setiap kolom yang diinginkan
        $sheet->setCellValue('E' . ($row), '=SUM(E' . $rowStart . ':E' . ($row - 1) . ')');
        $sheet->setCellValue('F' . ($row), '=SUM(F' . $rowStart . ':F' . ($row - 1) . ')');
        $sheet->setCellValue('G' . ($row), '=SUM(G' . $rowStart . ':G' . ($row - 1) . ')');
        $sheet->setCellValue('J' . ($row), '=SUM(J' . $rowStart . ':J' . ($row - 1) . ')');
        $sheet->setCellValue('K' . ($row), '=SUM(K' . $rowStart . ':K' . ($row - 1) . ')');
        $sheet->setCellValue('L' . ($row), '=SUM(L' . $rowStart . ':L' . ($row - 1) . ')');

        // Format untuk SUM (bold dan rata tengah)
        $sheet->getStyle('E' . ($row) . ':L' . ($row))->getFont()->setBold(true);
        $sheet->getStyle('E' . ($row) . ':L' . ($row))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
        // Menambahkan warna latar belakang pada baris SUM
        $sheet->getStyle('E' . ($row) . ':L' . ($row))
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFF00'); // Menggunakan warna kuning (FFFF00)
        // Atur auto size untuk kolom dari A hingga D
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Menambahkan border untuk seluruh data yang diisi
        $cellRange = 'A' . $rowStart . ':L' . $rowEnd;  // Sesuaikan dengan kolom yang digunakan

        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setColor(new Color(Color::COLOR_BLACK));

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Pajak_Report_' . date('YmdHis') . '.xlsx';
        $filePath = storage_path('app/public/reports/' . $fileName);

        $writer->save($filePath);

        return response()->download($filePath);
    }

    public function exportBpjsSheet($id, $skpd_id, $nosheet)
    {

        $templatePath = public_path('excel/bpjs.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        $skpd = Skpd::find($skpd_id);

        $bulanTahun = BulanTahun::find($id);

        if ($nosheet == 1) {
            $kategori = 'PENGAWAS & GURU TK';
        }
        if ($nosheet == 2) {
            $kategori = 'GURU SD';
        }
        if ($nosheet == 3) {
            $kategori = 'GURU SMP';
        }
        if ($nosheet == 4) {
            $kategori = 'GURU P3K & TEKNIS';
        }

        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->setCellValue('A1', strtoupper($skpd->nama) . ' - ' . $kategori);
        $sheet->setCellValue('A2', 'PERIODE : ' . $bulanTahun->bulan . ' ' . $bulanTahun->tahun);

        // Menambahkan format: Membuat teks tebal dan memusatkan teks
        $sheet->getStyle('A1:A2')->getFont()->setBold(true);
        //dd($skpd);
        $bpjs = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->where('sheet', $nosheet)->get()->sortByDesc('total_penghasilan')->values();
        if ($bpjs->count() === 0) {
            Session::flash('info', 'Tidak ada Data Untuk Di Export');
            return redirect()->back();
        }
        $rowStart = 6; // Mulai dari baris kedua (misalnya)
        $rowEnd = $rowStart + count($bpjs) - 1; // Baris akhir berdasarkan jumlah data


        $no = 1;
        foreach ($bpjs as $index => $bpj) {
            $row = $rowStart + $index;
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, "'" . $bpj->nip);
            $sheet->setCellValue('C' . $row, $bpj->nama);
            $sheet->setCellValue('D' . $row, $bpj->gapok);
            $sheet->setCellValue('E' . $row, $bpj->tjk);
            $sheet->setCellValue('F' . $row, $bpj->tjb);
            $sheet->setCellValue('G' . $row, $bpj->tjf);
            $sheet->setCellValue('H' . $row, $bpj->tjfu);
            $sheet->setCellValue('I' . $row, $bpj->jumlah_gaji);
            $sheet->setCellValue('J' . $row, $bpj->pagu);
            $sheet->setCellValue('K' . $row, 0);
            $sheet->setCellValue('L' . $row, 0);
            $sheet->setCellValue('M' . $row, 0);
            $sheet->setCellValue('N' . $row, $bpj->jumlah_tunjangan);
            $sheet->setCellValue('O' . $row, $bpj->jumlah_penghasilan);
            $sheet->setCellValue('P' . $row, $bpj->iuran_satu_persen);
            $sheet->setCellValue('Q' . $row, $bpj->iuran_empat_persen);
            $sheet->setCellValue('R' . $row, $bpj->gaji_satu_persen);
            $sheet->setCellValue('S' . $row, $bpj->gaji_empat_persen);
            $sheet->setCellValue('T' . $row, $bpj->tpp_satu_persen);
            $sheet->setCellValue('U' . $row, $bpj->tpp_empat_persen);
            // $sheet->setCellValue('F' . $row, $pajak->tpp);
            // $sheet->setCellValue('G' . $row, $pajak->total_penghasilan);
            // $sheet->setCellValue('H' . $row, $pajak->kelompok);
            // $sheet->setCellValue('I' . $row, $pajak->tarif);
            // $sheet->setCellValue('J' . $row, $pajak->pph_penghasilan);
            // $sheet->setCellValue('K' . $row, $pajak->pph_gaji);
            // $sheet->setCellValue('L' . $row, $pajak->pph_terutang);

            $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('M' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('N' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('O' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('P' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('Q' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('R' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('S' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('T' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('U' . $row)->getNumberFormat()->setFormatCode('#,##0');

            // $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            // $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        // Menambahkan SUM di bawah setiap kolom yang diinginkan
        $sheet->setCellValue('D' . ($row), '=SUM(D' . $rowStart . ':D' . ($row - 1) . ')');
        $sheet->setCellValue('E' . ($row), '=SUM(E' . $rowStart . ':E' . ($row - 1) . ')');
        $sheet->setCellValue('F' . ($row), '=SUM(F' . $rowStart . ':F' . ($row - 1) . ')');
        $sheet->setCellValue('G' . ($row), '=SUM(G' . $rowStart . ':G' . ($row - 1) . ')');
        $sheet->setCellValue('J' . ($row), '=SUM(J' . $rowStart . ':J' . ($row - 1) . ')');
        $sheet->setCellValue('K' . ($row), '=SUM(K' . $rowStart . ':K' . ($row - 1) . ')');
        $sheet->setCellValue('L' . ($row), '=SUM(L' . $rowStart . ':L' . ($row - 1) . ')');
        $sheet->setCellValue('M' . ($row), '=SUM(M' . $rowStart . ':M' . ($row - 1) . ')');
        $sheet->setCellValue('N' . ($row), '=SUM(N' . $rowStart . ':N' . ($row - 1) . ')');
        $sheet->setCellValue('O' . ($row), '=SUM(O' . $rowStart . ':O' . ($row - 1) . ')');
        $sheet->setCellValue('P' . ($row), '=SUM(P' . $rowStart . ':P' . ($row - 1) . ')');
        $sheet->setCellValue('Q' . ($row), '=SUM(Q' . $rowStart . ':Q' . ($row - 1) . ')');
        $sheet->setCellValue('R' . ($row), '=SUM(R' . $rowStart . ':R' . ($row - 1) . ')');
        $sheet->setCellValue('S' . ($row), '=SUM(S' . $rowStart . ':S' . ($row - 1) . ')');
        $sheet->setCellValue('T' . ($row), '=SUM(T' . $rowStart . ':T' . ($row - 1) . ')');
        $sheet->setCellValue('U' . ($row), '=SUM(U' . $rowStart . ':U' . ($row - 1) . ')');

        // Format untuk SUM (bold dan rata tengah)
        $sheet->getStyle('D' . ($row) . ':U' . ($row))->getFont()->setBold(true);
        $sheet->getStyle('D' . ($row) . ':U' . ($row))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('M' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('N' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('O' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('P' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('Q' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('R' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('S' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('T' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('U' . $row)->getNumberFormat()->setFormatCode('#,##0');
        // Menambahkan warna latar belakang pada baris SUM
        $sheet->getStyle('D' . ($row) . ':U' . ($row))
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFF00'); // Menggunakan warna kuning (FFFF00)
        // Atur auto size untuk kolom dari A hingga D
        foreach (range('A', 'U') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Menambahkan border untuk seluruh data yang diisi
        $cellRange = 'A' . $rowStart . ':U' . $rowEnd;  // Sesuaikan dengan kolom yang digunakan

        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setColor(new Color(Color::COLOR_BLACK));

        $writer = new Xlsx($spreadsheet);
        $fileName = 'BPJS_Report_' . date('YmdHis') . '.xlsx';
        $filePath = storage_path('app/public/reports/' . $fileName);

        $writer->save($filePath);


        return response()->download($filePath);
    }
}
