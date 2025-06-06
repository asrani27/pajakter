@extends('layouts.user')

@section('content')
<div class="row">
    <div class="col-12">

        @include('superadmin.pajak.guru.format')
        <br /><br />
        <div class="card">
            <div class="card-header">
                @include('superadmin.pajak.guru.menu')
            </div>
            <div class="card-body table-responsive">
                <div class="text-center" style="font-size: 20px">

                    <strong>SKPD : {{strtoupper($skpd->nama)}} (GURU)<br />
                        PERIODE : KINERJA {{strtoupper($bulanTahun->bulan)}} {{$bulanTahun->tahun}}
                    </strong>
                </div>

                @if (Auth::user()->skpd_id == 1)
                <form method="post" action="/admin/pajakter/{{$id}}/skpd/{{$skpd_id}}/guru"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" required>
                    <button type="submit" class="btn btn-sm btn-info" name="button" value="sheet4">
                        <i class="fa fa-upload"></i> UPLOAD GAJI</button>

                    <a href="/admin/pajakter/{{$id}}/skpd/{{$skpd_id}}/guruteknis/reset" class="btn btn-sm btn-danger"
                        onclick="return confirm('Yakin Di Hapus?');">
                        <i class="fa fa-times"></i> CLEAR DATA</a>
                    <a href="/admin/pajakter/{{$id}}/exportpajak/{{$skpd_id}}/sheet/4" class="btn btn-sm btn-primary">
                        <i class="fa fa-file-excel"></i> Export Pajak</a>
                </form>
                @else
                <form method="post" action="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/guru"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" required>
                    <button type="submit" class="btn btn-sm btn-info" name="button" value="sheet3">
                        <i class="fa fa-upload"></i> UPLOAD GAJ
                        <a href="/admin/pajakter/{{$id}}/skpd/{{$skpd_id}}/guruteknis/reset"
                            class="btn btn-sm btn-danger" onclick="return confirm('Yakin Di Hapus?');">
                            <i class="fa fa-times"></i> CLEAR DATA</a>
                        <a href="/admin/pajakter/{{$id}}/exportpajak/{{$skpd_id}}/sheet/4"
                            class="btn btn-sm btn-primary">
                            <i class="fa fa-file-excel"></i> Export Pajak</a></button>

                </form>
                @endif
                <br />
                <table class="table table-hover text-nowrap table-sm">
                    <thead style="background-color:#3d8b99;">
                        <tr class="text-white" style="font-size:14px; text-align:center;">
                            <th style="border: 1px solid rgb(19, 19, 19);vertical-align:middle" rowspan="2">No</th>
                            <th style="border: 1px solid rgb(19, 19, 19);vertical-align:middle" rowspan="2">NIP</th>
                            <th style="border: 1px solid rgb(19, 19, 19);vertical-align:middle" rowspan="2">Nama</th>
                            <th style="border: 1px solid rgb(19, 19, 19);vertical-align:middle" rowspan="2">PTKP
                            </th>
                            <th style="border: 1px solid rgb(19, 19, 19)" colspan="3">Penghasilan</th>
                            <th style="border: 1px solid rgb(19, 19, 19)" colspan="2">TER</th>
                            <th style="border: 1px solid rgb(19, 19, 19)" rowspan="2">PPh 21 Penghasilan</th>
                            <th style="border: 1px solid rgb(19, 19, 19)" rowspan="2">PPh 21 Gaji</th>
                            <th style="border: 1px solid rgb(19, 19, 19)" rowspan="2">PPh terutang</th>
                        </tr>
                        <tr class="text-white" style="font-size:14px; text-align:center">
                            <th style="border: 1px solid rgb(19, 19, 19)">Gaji</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">TPP &nbsp; &nbsp;
                                {{-- <a
                                    href="/superadmin/tariktpp/{{$bulanTahun->id}}/{{$bulanTahun->bulan}}/{{$bulanTahun->tahun}}"
                                    class="btn btn-xs btn-default">
                                    <i class="fa fa-recycle"></i>
                                </a> --}}
                            </th>
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
                        <tr style="font-size:14px;">
                            <td style="border: 1px solid rgb(19, 19, 19);">{{$no++}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19);">{{$item->nip}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19);">{{$item->nama}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:center;">{{$item->ptkp}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->gaji)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->tpp)}}</td>
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
                        @endforeach
                        <tr style="background-color:#3d8b99;" class="text-white text-bold">
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;" colspan="9">TOTAL</td>
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