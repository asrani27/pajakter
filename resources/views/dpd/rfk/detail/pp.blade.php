@extends('layouts.user')
@push('css')

@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <br />

        @include('dpd.rfk.detail.menu')

        <br /> <br />

        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-bold">LAPORAN REALISASI FISIK DAN KEUANGAN</h3>
            </div>
            <div class="card-body table-responsive">
                <table style="font-weight: bold;font-size:14px">
                    <tr>
                        <td>NAMA KAB/KOTA</td>
                        <td>: {{$data->nama}}</td>
                    </tr>
                    <tr>
                        <td>BIDANG</td>
                        <td>: BIDANG PEMBERDAYAAN POLITIK</td>
                    </tr>
                    <tr>
                        <td>KONDISI S/D TGL</td>
                        <td>: {{\Carbon\Carbon::parse($data->kondisi)->format('d-m-Y')}}</td>
                    </tr>
                </table>

                {{-- <table class="table table-sm" style="border: 1px solid black; text-align:center">
                    <thead>
                        <tr style="font-size:12px" class="bg-warning" style="border: 1px solid black">
                            <th style="border: 1px solid black" rowspan="3"></th>
                            <th style="border: 1px solid black" rowspan="3">No</th>
                            <th style="border: 1px solid black" rowspan="3">KODE AKUN</th>
                            <th style="border: 1px solid black" rowspan="3">URAIAN PROGRAM</th>
                            <th style="border: 1px solid black" rowspan="3">INDIKATOR</th>
                            <th style="border: 1px solid black" rowspan="3">KEGIATAN</th>
                            <th style="border: 1px solid black" rowspan="3">PENANGGUNG JAWAB</th>
                            <th style="border: 1px solid black" rowspan="3">TANGGAL PELAKSANAAN</th>
                            <th style="border: 1px solid black" colspan="4" rowspan="2">Rencana Anggaran (RA) dari Ketua
                                PPNI</th>
                            <th style="border: 1px solid black" colspan="23">CAPAIAN SAMPAI DENGAN
                                {{\Carbon\Carbon::parse($data->kondisi)->translatedFormat('d F Y')}}</th>
                            <th style="border: 1px solid black" rowspan="3">SISA ANGGARAN</th>
                        </tr>
                        <tr style="font-size:12px" class="bg-warning">
                            <th colspan="5" style="border: 1px solid black">Rencana Realisasi (RR)</th>

                            <th colspan="15" style="border: 1px solid black">Realisasi Fisik (RF)</th>
                            <th colspan="3" style="border: 1px solid black">Realisasi Keuangan (RK)</th>
                        </tr>
                        <tr style="font-size:12px" class="bg-warning">
                            <th style="border: 1px solid black">Volume</th>
                            <th style="border: 1px solid black">Satuan</th>
                            <th style="border: 1px solid black">Harga Satuan</th>
                            <th style="border: 1px solid black">Jumlah Anggaran</th>
                            <th style="border: 1px solid black">Bobot %</th>
                            <th style="border: 1px solid black">Volume RR</th>
                            <th style="border: 1px solid black">Fisik % RR</th>
                            <th style="border: 1px solid black">Tertimbang % RR</th>
                            <th style="border: 1px solid black">Keuangan Rp</th>
                            <th style="border: 1px solid black">Jan</th>
                            <th style="border: 1px solid black">Feb</th>
                            <th style="border: 1px solid black">Mar</th>
                            <th style="border: 1px solid black">Apr</th>
                            <th style="border: 1px solid black">Mei</th>
                            <th style="border: 1px solid black">Jun</th>
                            <th style="border: 1px solid black">Jul</th>
                            <th style="border: 1px solid black">Agus</th>
                            <th style="border: 1px solid black">Sept</th>
                            <th style="border: 1px solid black">Okt</th>
                            <th style="border: 1px solid black">Nov</th>
                            <th style="border: 1px solid black">Des</th>
                            <th style="border: 1px solid black">Volume RF</th>
                            <th style="border: 1px solid black">Fisik % RF</th>
                            <th style="border: 1px solid black">Tertimbang % RF</th>
                            <th style="border: 1px solid black">Rupiah</th>
                            <th style="border: 1px solid black">Persentase</th>
                            <th style="border: 1px solid black">Tertimbang</th>
                        </tr>
                        <tr style="font-size: 8px;background-color:silver">
                            <th style="border: 1px solid black">0</th>
                            <th style="border: 1px solid black">1</th>
                            <th style="border: 1px solid black">2</th>
                            <th style="border: 1px solid black">3</th>
                            <th style="border: 1px solid black">4</th>
                            <th style="border: 1px solid black">5</th>
                            <th style="border: 1px solid black">6</th>
                            <th style="border: 1px solid black">7</th>
                            <th style="border: 1px solid black">8</th>
                            <th style="border: 1px solid black">9</th>
                            <th style="border: 1px solid black">10</th>
                            <th style="border: 1px solid black">11</th>
                            <th style="border: 1px solid black">12</th>
                            <th style="border: 1px solid black">13</th>
                            <th style="border: 1px solid black">14</th>
                            <th style="border: 1px solid black">15</th>
                            <th style="border: 1px solid black">16</th>
                            <th style="border: 1px solid black">17</th>
                            <th style="border: 1px solid black">18</th>
                            <th style="border: 1px solid black">19</th>
                            <th style="border: 1px solid black">20</th>
                            <th style="border: 1px solid black">21</th>
                            <th style="border: 1px solid black">22</th>
                            <th style="border: 1px solid black">23</th>
                            <th style="border: 1px solid black">24</th>
                            <th style="border: 1px solid black">25</th>
                            <th style="border: 1px solid black">26</th>
                            <th style="border: 1px solid black">27</th>
                            <th style="border: 1px solid black">28</th>
                            <th style="border: 1px solid black">29</th>
                            <th style="border: 1px solid black">30</th>
                            <th style="border: 1px solid black">31</th>
                            <th style="border: 1px solid black">32</th>
                            <th style="border: 1px solid black">33</th>
                            <th style="border: 1px solid black">34</th>
                            <th style="border: 1px solid black">35</th>
                        </tr>

                        @foreach ($data->hp as $key=> $item)
                        <tr style="font-size:12px; background-color:rgb(235, 235, 232)">

                            <td style="display:flex;">
                                <a href="/dpd/rfk/detail/{{$id}}/hp/edit/{{$item->id}}"> <i class="fa fa-edit"></i>
                                </a>
                                &nbsp;&nbsp;&nbsp;
                                <a href="/dpd/rfk/detail/{{$id}}/hp/delete/{{$item->id}}"
                                    onclick="return confirm('Yakin ingin dihapus?');" class="text-red">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                            <td style="border: 1px solid black">{{$key+1}}</td>
                            <td style="border: 1px solid black" class="text-bold text-left">{{$item->kode_akun}}

                                <a href="/dpd/rfk/detail/{{$id}}/hp/sub/{{$item->id}}"><i
                                        class="fa fa-plus-circle"></i>sub</a>
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-left">
                                {{$item->program}}</td>
                            <td style="border: 1px solid black" class="text-bold text-left">{{$item->indikator}}</td>
                            <td style="border: 1px solid black" class="text-bold text-left">{{$item->kegiatan}}</td>
                            <td style="border: 1px solid black" class="text-bold text-left">{{$item->penanggung_jawab}}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-left">
                                {{$item->tanggal_pelaksanaan}}</td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{number_format($item->sub->sum('volume'))}}</td>
                            <td style="border: 1px solid black" class="text-bold text-left">
                                {{$item->satuan}}</td>
                            <td style="border: 1px solid black" class="text-bold text-right">
                                {{number_format($item->sub->sum('harga_satuan'))}}</td>

                            <td style="border: 1px solid black" class="text-bold text-right">
                                {{number_format($item->total_jumlah_anggaran)}}</td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->total_bobot_persen,2) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{number_format($item->sub->sum('volume_rr'))}}</td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->total_fisik_rr,2) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->total_tertimbang_rr,2) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-right">
                                {{ number_format($item->total_keuangan_rr) }}
                            </td>

                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->sub->sum('jan')) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->sub->sum('feb')) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->sub->sum('mar')) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->sub->sum('apr')) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->sub->sum('mei')) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->sub->sum('jun')) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->sub->sum('jul')) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->sub->sum('augt')) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->sub->sum('sept')) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->sub->sum('okt')) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->sub->sum('nov')) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->sub->sum('des')) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->total_volume_rf) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->total_fisik_rf,2) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->total_tertimbang_rf,2) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-right">
                                {{ number_format($item->total_rupiah_rk) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->total_persen_rk,2) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-center">
                                {{ number_format($item->total_tertimbang_rk,2) }}
                            </td>
                            <td style="border: 1px solid black" class="text-bold text-right">
                                {{ number_format($item->total_sisa_anggaran) }}
                            </td>
                        </tr>

                        @foreach ($item->sub as $subkey => $subitem)
                        <tr style="font-size:12px; background-color:rgb(255, 255, 251)">

                            <td style="display:flex;">
                                <a href="/dpd/rfk/detail/{{$id}}/hp/sub/{{$subitem->rfkhp->id}}/edit/{{$subitem->id}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                &nbsp;&nbsp;&nbsp;
                                <a href="/dpd/rfk/detail/{{$id}}/hp/sub/{{$subitem->rfkhp->id}}/delete/{{$subitem->id}}"
                                    onclick="return confirm('Yakin ingin dihapus?');" class="text-red">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                            <td style="border: 1px solid black"></td>
                            <td style="border: 1px solid black" class="text-left">{{$subitem->kode_akun}}


                            </td>
                            <td style="border: 1px solid black" class="text-left">{{$subitem->program}}</td>
                            <td style="border: 1px solid black" class="text-left">{{$subitem->indikator}}</td>
                            <td style="border: 1px solid black" class="text-left">{{$subitem->kegiatan}}</td>
                            <td style="border: 1px solid black" class="text-left">
                                {{$subitem->penanggung_jawab}}
                            </td>
                            <td style="border: 1px solid black" class="text-left">
                                {{$subitem->tanggal_pelaksanaan}}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{number_format($subitem->volume)}}</td>
                            <td style="border: 1px solid black" class="text-left">
                                {{$subitem->satuan}}</td>
                            <td style="border: 1px solid black" class="text-right">
                                {{number_format($subitem->harga_satuan)}}</td>
                            <td style="border: 1px solid black" class="text-right">
                                {{number_format($subitem->JumlahAnggaran)}}
                            </td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->bobot_persen,2) }}
                            </td>
                            <td style="border: 1px solid black" class="text-center">
                                {{number_format($subitem->volume_rr)}}</td>
                            </td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->fisik_rr,2) }}
                            </td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->tertimbang_rr,2) }}
                            </td>

                            <td style="border: 1px solid black" class="text-right">
                                {{ number_format($subitem->keuangan_rr) }}
                            </td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->jan) }}
                            </td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->feb) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->mar) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->apr) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->mei) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->jun) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->jul) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->augt) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->sept) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->okt) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->nov) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->des) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->volume_rf) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->fisik_rf, 2) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->tertimbang_rf, 2) }}</td>
                            <td style="border: 1px solid black" class="text-right">
                                {{ number_format($subitem->rupiah_rk) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->persen_rk,2) }}</td>
                            <td style="border: 1px solid black" class="text-center">
                                {{ number_format($subitem->tertimbang_rk,2) }}</td>
                            <td style="border: 1px solid black" class="text-right">
                                {{ number_format($subitem->sisa_anggaran) }}</td>
                        </tr>
                        @endforeach
                        @endforeach
                        <tr style="font-size:12px;background-color:rgb(191, 253, 233)">
                            <th style="border: 1px solid black; vertical-align:top" colspan="8">JUMLAH</th>
                            <th style="border: 1px solid black">{{$data->hp->sum('total_volume')}}</th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black">{{number_format($data->hp->sum('total_harga_satuan'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_jumlah_anggaran'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_bobot_persen'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_volume_rr'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_fisik_rr'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_tertimbang_rr'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_keuangan_rr'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_jan'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_feb'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_mar'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_apr'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_mei'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_jun'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_jul'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_augt'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_sept'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_okt'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_nov'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_des'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_volume_rf'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_fisik_rf'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_tertimbang_rf'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_rupiah_rk'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_persen_rk'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_tertimbang_rk'))}}
                            </th>
                            <th style="border: 1px solid black">
                                {{number_format($data->hp->sum('total_sisa_anggaran'))}}
                            </th>
                        </tr>
                        <tr style="background-color: bisque">
                            <th style="border: 1px solid black; vertical-align:top"></th>
                            <th style="border: 1px solid black; vertical-align:top"></th>
                            <form id="add-form" method="POST" action="/dpd/rfk/detail/{{$id}}/hp">
                                @csrf
                                <th style="border: 1px solid black; vertical-align:top">
                                    <textarea style="font-size: 14px" cols="30" rows="5" name="kode_akun"
                                        required></textarea>
                                    <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-save"></i>
                                        SIMPAN</button>
                                </th>
                                <th style="border: 1px solid black; vertical-align:top">
                                    <textarea style="font-size: 14px" cols="50" rows="5" name="program"></textarea>
                                </th>
                                <th style="border: 1px solid black; vertical-align:top">
                                    <textarea style="font-size: 14px" rows="5" name="indikator"></textarea>
                                </th>
                                <th style="border: 1px solid black; vertical-align:top">
                                    <textarea style="font-size: 14px" rows="5" name="kegiatan"></textarea>
                                </th>
                                <th style="border: 1px solid black; vertical-align:top">
                                    <textarea style="font-size: 14px" rows="5" name="penanggung_jawab"></textarea>
                                </th>
                                <th style="border: 1px solid black; vertical-align:top">
                                    <textarea style="font-size: 14px" rows="5" name="tanggal_pelaksanaan"></textarea>
                                </th>
                                <th style="border: 1px solid black"></th>
                                <th style="border: 1px solid black; vertical-align:top">
                                    <input type="text" name="satuan" value="kali">
                                </th>
                            </form>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                            <th style="border: 1px solid black"></th>
                        </tr>
                    </thead>
                </table> --}}
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Periksa apakah ada data posisi scroll yang disimpan
        const scrollPosition = localStorage.getItem('scrollPosition');
        
        if (scrollPosition) {
            // Setel posisi scroll halaman ke posisi yang disimpan
            window.scrollTo(0, scrollPosition);
            localStorage.removeItem('scrollPosition'); // Hapus data setelah digunakan
        }

        // Simpan posisi scroll sebelum reload
        window.onbeforeunload = function () {
            localStorage.setItem('scrollPosition', window.scrollY);
        };
    });
</script>
<script>
    function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
       if (charCode > 31 && (charCode < 48 || charCode > 57))

        return false;
      return true;
    }
</script>
@endpush