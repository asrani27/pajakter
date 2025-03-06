@extends('layouts.user')

@section('content')
<div class="row">
    <div class="col-12">
        <a href="/admin" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>
            Kembali
        </a><br /><br />
        <div class="card">
            <div class="card-body table-responsive">
                <div class="text-center" style="font-size: 20px">

                    <strong>SKPD : {{strtoupper($skpd->nama)}}<br />
                        PERIODE : KINERJA {{strtoupper($bulanTahun->bulan)}} {{$bulanTahun->tahun}}, DIBAYAR :
                        {{nextMonth($bulanTahun->bulan, $bulanTahun->tahun)}}<br />
                    </strong>
                </div>
                <a href="/admin/pajakter/{{$id}}/exportpajak/{{$skpd_id}}" class="btn btn-sm btn-primary">
                    <i class="fa fa-file-excel"></i> Export Pajak</a>
                <a href="/admin/pajakter/{{$id}}/exportbpjs/{{$skpd_id}}" class="btn btn-sm btn-primary">
                    <i class="fa fa-file-excel"></i> Export BPJS</a>
                <a href="/admin/bpjs/{{$id}}" class="btn btn-sm btn-info">
                    <i class="fa fa-users"></i> BPJS</a>
                <br />
                {{-- <a href="/admin/pajakter/{{$id}}/skpd/{{$skpd_id}}/reset" class="btn btn-sm btn-danger"
                    onclick="return confirm('Yakin Di Hapus?');">
                    <i class="fa fa-times"></i> CLEAR DATA</a> --}}


                <br />
                <table class="table table-hover text-nowrap table-sm">
                    <thead style="background-color:#3d8b99;">
                        <tr class="text-white" style="font-size:14px; text-align:center;">
                            <th style="border: 1px solid rgb(19, 19, 19);vertical-align:middle" rowspan="2">No</th>
                            <th style="border: 1px solid rgb(19, 19, 19);vertical-align:middle" rowspan="2">NIP</th>
                            <th style="border: 1px solid rgb(19, 19, 19);vertical-align:middle" rowspan="2">Nama</th>
                            <th style="border: 1px solid rgb(19, 19, 19);vertical-align:middle" rowspan="2">PTKP
                            </th>
                            <th style="border: 1px solid rgb(19, 19, 19)" colspan="4">Penghasilan</th>
                            <th style="border: 1px solid rgb(19, 19, 19)" colspan="2">TER</th>
                            <th style="border: 1px solid rgb(19, 19, 19)" rowspan="2">PPh 21 Penghasilan</th>
                            <th style="border: 1px solid rgb(19, 19, 19)" rowspan="2">PPh 21 Gaji</th>
                            <th style="border: 1px solid rgb(19, 19, 19)" rowspan="2">PPh terutang</th>
                        </tr>
                        <tr class="text-white" style="font-size:14px; text-align:center">
                            <th style="border: 1px solid rgb(19, 19, 19)">Gaji</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">TPP &nbsp; &nbsp;
                                <a href="/admin/tariktpp/{{$bulanTahun->id}}/{{$bulanTahun->bulan}}/{{$bulanTahun->tahun}}/{{$skpd_id}}"
                                    class="btn btn-xs btn-default">
                                    <i class="fa fa-recycle"></i>
                                </a>
                            </th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Tukin PLT</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Total</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Kelompok</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Tarif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no =1;
                        @endphp
                        @foreach ($data as $key => $item)
                        @if ($edit != null)

                        @if ($edit->id === $item->id)
                        <tr style="font-size:14px;">
                            <td style="border: 1px solid rgb(19, 19, 19);">{{$no++}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19);">{{$item->nip}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19);">{{$item->nama}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:center;">
                                <form method="post" action="/admin/pajakter/{{$bulanTahun->id}}/editptkp/{{$item->id}}">
                                    @csrf
                                    <select class="form-control-sm" name="ptkp">
                                        <option value="K/0" {{$edit->ptkp == 'K/0' ? 'selected':''}}>K/0</option>
                                        <option value="K/1" {{$edit->ptkp == 'K/1' ? 'selected':''}}>K/1</option>
                                        <option value="K/2" {{$edit->ptkp == 'K/2' ? 'selected':''}}>K/2</option>
                                        <option value="K/3" {{$edit->ptkp == 'K/3' ? 'selected':''}}>K/3</option>
                                        <option value="TK/0" {{$edit->ptkp == 'TK/0' ? 'selected':''}}>TK/0</option>
                                        <option value="TK/1" {{$edit->ptkp == 'TK/1' ? 'selected':''}}>TK/1</option>
                                        <option value="TK/2" {{$edit->ptkp == 'TK/2' ? 'selected':''}}>TK/2</option>
                                        <option value="TK/3" {{$edit->ptkp == 'TK/3' ? 'selected':''}}>TK/3</option>
                                    </select>
                                    <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-save"></i>
                                        update</button>
                                </form>
                            </td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->gaji)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->tpp)}}</td>

                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->tpp_plt)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->total_penghasilan)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:center;">
                                {{$item->kelompok}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:center;">
                                {{$item->tarif}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->pph_penghasilan)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->pph_gaji)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->pph_terutang)}}</td>
                        </tr>
                        @else

                        <tr style="font-size:14px;">
                            <td style="border: 1px solid rgb(19, 19, 19);">{{$no++}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19);">{{$item->nip}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19);">{{$item->nama}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:center;">{{$item->ptkp}}
                                <a href="/admin/pajakter/{{$bulanTahun->id}}/editptkp/{{$item->id}}"><i
                                        class="fa fa-edit"></i></a>
                            </td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->gaji)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->tpp)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->tpp_plt)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->total_penghasilan)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:center;">
                                {{$item->kelompok}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:center;">
                                {{$item->tarif}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->pph_penghasilan)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->pph_gaji)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->pph_terutang)}}</td>
                        </tr>
                        @endif
                        @else
                        <tr style="font-size:14px;">
                            <td style="border: 1px solid rgb(19, 19, 19);">{{$no++}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19);">{{$item->nip}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19);">{{$item->nama}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:center;">{{$item->ptkp}}
                                <a href="/admin/pajakter/{{$bulanTahun->id}}/editptkp/{{$item->id}}"><i
                                        class="fa fa-edit"></i></a>
                            </td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->gaji)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->tpp)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->tpp_plt)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->total_penghasilan)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:center;">
                                {{$item->kelompok}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:center;">
                                {{$item->tarif}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->pph_penghasilan)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->pph_gaji)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->pph_terutang)}}</td>
                        </tr>
                        @endif

                        @endforeach
                        <tr style="background-color:#3d8b99;" class="text-white text-bold">
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;" colspan="10">TOTAL</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('pph_penghasilan'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('pph_gaji'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('pph_terutang'))}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
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
@endpush