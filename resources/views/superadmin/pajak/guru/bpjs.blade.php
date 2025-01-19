@extends('layouts.user')

@section('content')
<div class="row">
    <div class="col-12">
        <a href="/superadmin/pajakter" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>
            Kembali
        </a><br /><br />
        <div class="card">
            <div class="card-header">
                @include('superadmin.pajak.guru.menu')
            </div>
            <div class="card-body table-responsive">
                <div class="text-center" style="font-size: 20px">
                    <strong>BPJS GURU <br />
                        PERIODE : {{strtoupper($bulanTahun->bulan)}} {{$bulanTahun->tahun}} (BPJS)<br />
                    </strong>
                </div>
                {{-- <form method="post" action="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/importpegawai"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" required>
                    <button type="submit" class="btn btn-sm btn-info">
                        <i class="fa fa-upload"></i> UPLOAD GAJI ASN</button>

                    <a href="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/reset" class="btn btn-sm btn-danger"
                        onclick="return confirm('Yakin Di Hapus?');">
                        <i class="fa fa-times"></i> CLEAR DATA</a>

                </form>
                <br /> --}}
                <table class="table table-hover text-nowrap table-sm">
                    <thead style="background-color:#3d8b99;">
                        <tr class="text-white" style="font-size:14px; text-align:center;">
                            <th style="border: 1px solid rgb(19, 19, 19);vertical-align:middle" rowspan="2">No</th>
                            <th style="border: 1px solid rgb(19, 19, 19);vertical-align:middle" rowspan="2">NIP</th>
                            <th style="border: 1px solid rgb(19, 19, 19);vertical-align:middle" rowspan="2">Nama</th>
                            <th style="border: 1px solid rgb(19, 19, 19)" colspan="5">GAJI</th>
                            <th style="border: 1px solid rgb(19, 19, 19);vertical-align:middle" rowspan="2">Jumlah Gaji
                            </th>

                            <th style="border: 1px solid rgb(19, 19, 19)" colspan="4">TUNJANGAN LAINNYA</th>
                            <th style="border: 1px solid rgb(19, 19, 19)" rowspan="2">Jumlah<br /> Tunjangan</th>
                            <th style="border: 1px solid rgb(19, 19, 19); background-color:rgb(243, 250, 215);color:black"
                                rowspan="
                                2">
                                Jumlah<br /> Penghasilan</th>
                            <th style="border: 1px solid rgb(19, 19, 19);background-color:rgb(243, 250, 215);color:black"
                                colspan="2"> TOTAL IURAN BPJS ( GJ + TJ
                                )</th>
                            <th style="border: 1px solid rgb(19, 19, 19);background-color:rgb(243, 250, 215);color:black"
                                colspan="2">IWP Gaji (BPJS)</th>
                            <th style="border: 1px solid rgb(19, 19, 19);background-color:rgb(243, 250, 215);color:black"
                                colspan="2">IWP TPP (BPJS)</th>
                        </tr>
                        <tr class="text-white" style="font-size:12px; text-align:center">
                            <th style="border: 1px solid rgb(19, 19, 19)">Gaji Pokok</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">TJ Keluarga</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">TJ Jabatan</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">TJ Fungsional</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">TJ Fungsional Umum</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Tukin &nbsp; &nbsp;


                            </th>
                            <th style="border: 1px solid rgb(19, 19, 19)">TPP</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Sertifikasi</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Jaspel</th>
                            <th
                                style="border: 1px solid rgb(19, 19, 19);background-color:rgb(189, 248, 199);color:black;">
                                IWP1%
                            </th>
                            <th
                                style="border: 1px solid rgb(19, 19, 19);background-color:rgb(254, 245, 173);color:black;">
                                IWP4%</th>
                            <th
                                style="border: 1px solid rgb(19, 19, 19);background-color:rgb(189, 234, 248);color:black;">
                                IWP1%</th>
                            <th
                                style="border: 1px solid rgb(19, 19, 19);background-color:rgb(254, 245, 173);color:black;">
                                IWP4%</th>
                            <th
                                style="border: 1px solid rgb(19, 19, 19);background-color:rgb(189, 234, 248);color:black;">
                                IWP1%</th>
                            <th
                                style="border: 1px solid rgb(19, 19, 19);background-color:rgb(254, 245, 173);color:black;">
                                IWP4%</th>
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
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->gapok)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->tjk)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->tjb)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->tjf)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->tjfu)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->jumlah_gaji)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:center;">
                                {{number_format($item->tpp)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:center;">
                                {{number_format(0)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:center;">
                                {{number_format(0)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:center;">
                                {{number_format(0)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($item->jumlah_tunjangan)}}</td>
                            <td
                                style="border: 1px solid rgb(19, 19, 19); text-align:right; background-color:rgb(243, 250, 215);">
                                {{number_format($item->jumlah_penghasilan)}}</td>
                            <td
                                style="border: 1px solid rgb(19, 19, 19); text-align:right; background-color:rgb(189, 248, 199);">
                                {{number_format($item->iuran_satu_persen)}}</td>
                            <td
                                style="border: 1px solid rgb(19, 19, 19); text-align:right;background-color:rgb(254, 245, 173);">
                                {{number_format($item->iuran_empat_persen)}}</td>
                            <td
                                style="border: 1px solid rgb(19, 19, 19); text-align:right;background-color:rgb(189, 234, 248);">
                                {{number_format($item->gaji_satu_persen)}}</td>
                            <td
                                style="border: 1px solid rgb(19, 19, 19); text-align:right;background-color:rgb(254, 245, 173);">
                                {{number_format($item->gaji_empat_persen)}}</td>
                            <td
                                style="border: 1px solid rgb(19, 19, 19); text-align:right;background-color:rgb(189, 234, 248);">
                                {{number_format($item->tpp_satu_persen)}}</td>
                            <td
                                style="border: 1px solid rgb(19, 19, 19); text-align:right;background-color:rgb(254, 245, 173);">
                                {{number_format($item->tpp_empat_persen)}}</td>

                        </tr>
                        @endforeach
                        <tr style="background-color:#3d8b99;" class="text-white text-bold">
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;" colspan="3">TOTAL</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('gapok'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('tjk'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('tjb'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('tjf'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('tjfu'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('jumlah_gaji'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('tpp'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format(0)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format(0)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format(0)}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('jumlah_tunjangan'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('jumlah_penghasilan'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('iuran_satu_persen'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('iuran_empat_persen'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('gaji_satu_persen'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('gaji_empat_persen'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('tpp_satu_persen'))}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;">
                                {{number_format($data->sum('tpp_empat_persen'))}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@endsection