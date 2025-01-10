@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <a href="/superadmin/pajakter" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>
                Kembali
            </a><br /><br />
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data SKPD</h3>

                    <div class="card-tools">
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table class="table table-hover text-nowrap table-sm">
                        <thead style="background-color:#3d8b99;">
                            <tr class="text-white">
                                <th style="border: 1px solid rgb(19, 19, 19)">No</th>
                                <th style="border: 1px solid rgb(19, 19, 19)">Nama</th>
                                <th style="border: 1px solid rgb(19, 19, 19)">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($skpd as $key => $item)
                            <tr>
                                <td style="border: 1px solid rgb(19, 19, 19)">{{$key + 1}}</td>
                                <td style="border: 1px solid rgb(19, 19, 19)">{{$item->nama}}</td>
                                <td style="border: 1px solid rgb(19, 19, 19)">
                                    <a href="/superadmin/pajakter/{{$id}}/skpd/{{$item->id}}"
                                        class="btn btn-sm {{$item->pajak($id) == false ? 'btn-info' : 'btn-success'}}"><i
                                            class="fa fa-clipboard"></i> Hitung Pajak</a>

                                    <a href="/superadmin/pajakter/{{$id}}/skpd/{{$item->id}}/bpjs"
                                        class="btn btn-sm {{$item->pajak($id) == false ? 'btn-info' : 'btn-success'}}"><i
                                            class="fa fa-clipboard"></i> BPJS</a>
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