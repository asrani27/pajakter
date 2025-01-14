@extends('layouts.user')

@section('content')
<div class="row">
    <div class="col-12">
        <a href="/superadmin/pajakter/{{$id}}/skpd" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>
            Kembali
        </a><br /><br />
        <div class="card">
            <div class="card-body table-responsive">
                <div class="text-center" style="font-size: 20px">
                    <strong>SKPD : {{strtoupper($skpd->nama)}}<br />
                        PERIODE : {{strtoupper($bulanTahun->bulan)}} {{$bulanTahun->tahun}}<br />
                    </strong>
                </div>
                <form method="post" action="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/importpegawai"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" required>
                    <button type="submit" class="btn btn-sm btn-info">
                        <i class="fa fa-upload"></i> UPLOAD GAJI ASN</button>

                    <a href="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/reset" class="btn btn-sm btn-danger"
                        onclick="return confirm('Yakin Di Hapus?');">
                        <i class="fa fa-times"></i> CLEAR DATA</a>
                    <a href="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/bpjs" class="btn btn-sm btn-info">
                        <i class="fa fa-university"></i> BPJS</a>

                </form>
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
                            <th style="border: 1px solid rgb(19, 19, 19)" rowspan="2">PPh Terutang</th>
                        </tr>
                        <tr class="text-white" style="font-size:14px; text-align:center">
                            <th style="border: 1px solid rgb(19, 19, 19)">Gaji</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">TPP &nbsp; &nbsp;
                                <a href="/superadmin/tariktpp/{{$bulanTahun->id}}/{{$bulanTahun->bulan}}/{{$bulanTahun->tahun}}/{{$skpd_id}}"
                                    class="btn btn-xs btn-default">
                                    <i class="fa fa-recycle"></i>
                                </a>
                            </th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Total</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Kelompok</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Tarif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                        <tr style="font-size:14px;">
                            <td style="border: 1px solid rgb(19, 19, 19);">{{$key + 1}}</td>
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
                                {{number_format($item->pph_terutang)}}</td>
                        </tr>
                        @endforeach
                        <tr style="background-color:#3d8b99;" class="text-white text-bold">
                            <td style="border: 1px solid rgb(19, 19, 19); text-align:right;" colspan="9">TOTAL</td>
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