@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <img src="/logo/bjm.png" height="120px"><br /><br />
            <h2>Hi, {{Auth::user()->name}}, Selamat Datang Di Aplikasi Perhitungan Pajak ASN</h2>

            <div class="card" style="box-shadow: 0 1px 5px black">
                <div class="card-header" style="cursor: move;">

                    <h3 class="card-title">
                        <i class="fa fa-list"></i>
                        Silahkan pilih menu di bawah ini untuk mengelola konten anda
                    </h3>
                    <!-- tools card -->
                    <div class="card-tools">

                    </div>
                    <!-- /. tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <table class="table table-hover text-nowrap table-sm">
                        <thead style="background-color:#3d8b99;">
                            <tr class="text-white">
                                <th style="border: 1px solid rgb(19, 19, 19)">No</th>
                                <th style="border: 1px solid rgb(19, 19, 19)">Bulan - Tahun</th>
                                <th style="border: 1px solid rgb(19, 19, 19)">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bulantahun as $key => $item)
                            <tr>
                                <td style="border: 1px solid rgb(19, 19, 19)">{{$key + 1}}</td>
                                <td style="border: 1px solid rgb(19, 19, 19)">{{$item->bulan}} {{$item->tahun}}</td>
                                <td style="border: 1px solid rgb(19, 19, 19)">
                                    @if (Auth::user()->name = 'Dinas Kesehatan')
                                    <a href="/admin/pajakter/{{$item->id}}/pppk" class="btn btn-sm btn-info"><i
                                            class="fa fa-users"></i> PPPK</a>
                                    @endif
                                    <a href="/admin/pajakter/{{$item->id}}/" class="btn btn-sm btn-info"><i
                                            class="fa fa-eye"></i> PAJAK</a>
                                    <a href="/admin/bpjs/{{$item->id}}/" class="btn btn-sm btn-info"><i
                                            class="fa fa-eye"></i> BPJS</a>
                                    @if (Auth::user()->skpd_id == 1)
                                    <a href="/admin/pajakter/{{$item->id}}/skpd/{{Auth::user()->skpd_id}}/guru"
                                        class="btn btn-sm btn-info"><i class="fa fa-users"></i> GURU</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
@endsection