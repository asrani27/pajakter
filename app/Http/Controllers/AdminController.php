<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Models\Pajak;
use App\Models\BulanTahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        $bulantahun = BulanTahun::get();
        return view('admin.home', compact('bulantahun'));
    }

    public function editPtkp($id, $ptkp_id)
    {
        $edit = Pajak::find($ptkp_id);
        $skpd_id = Auth::user()->skpd_id;
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find(Auth::user()->skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', Auth::user()->skpd_id)->get()->sortByDesc('total_penghasilan');
        return view('admin.hitung', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data', 'edit'));
    }

    public function updatePtkp(Request $req, $id, $ptkp_id)
    {
        // Mapping PTKP ke status_kawin dan jumlah_tanggungan
        $ptkpMap = [
            'K/0' => [1, 0],
            'K/1' => [1, 1],
            'K/2' => [1, 2],
            'K/3' => [1, 3],
            'TK/0' => [2, 0],
            'TK/1' => [2, 1],
            'TK/2' => [2, 2],
            'TK/3' => [2, 3],
        ];

        // Ambil status_kawin dan jumlah_tanggungan berdasarkan PTKP
        [$status_kawin, $jumlah_tanggungan] = $ptkpMap[$req->ptkp] ?? [null, null];

        // Validasi jika PTKP tidak ditemukan
        if (is_null($status_kawin) || is_null($jumlah_tanggungan)) {
            Session::flash('error', 'PTKP tidak valid');
            return back();
        }

        // Update data pada tabel Pajak
        Pajak::find($ptkp_id)->update([
            'status_kawin' => $status_kawin,
            'jumlah_tanggungan' => $jumlah_tanggungan,
        ]);

        Session::flash('success', 'PTKP berhasil diperbarui');
        return redirect('/admin/pajakter/' . $id);
    }
    public function bpjs($id)
    {
        $skpd_id = Auth::user()->skpd_id;
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find($skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', $skpd_id)->get()->sortByDesc('jumlah_penghasilan');
        return view('admin.bpjs', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data'));
    }
    public function pajak($id)
    {
        $skpd_id = Auth::user()->skpd_id;
        $bulanTahun = BulanTahun::find($id);
        $skpd = Skpd::find(Auth::user()->skpd_id);
        $data = Pajak::where('bulan_tahun_id', $id)->where('skpd_id', Auth::user()->skpd_id)->get()->sortByDesc('total_penghasilan');
        $edit = null;
        return view('admin.hitung', compact('skpd', 'id', 'bulanTahun', 'skpd_id', 'data', 'edit'));
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
            ]);
        }


        $list = Pajak::where('bulan_tahun_id', $id)->whereIn('nip', $arrayString)->update(['skpd_id' => $skpd_id]);


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
}
