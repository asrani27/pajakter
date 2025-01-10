@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-12">
            <a href="/superadmin/pajakter/create-bulan-tahun" class="btn btn-sm btn-default"><i
                    class="fa fa-plus-circle"></i>
                Tambah
                Data</a><br /><br />
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Pajak TER</h3>

                    <div class="card-tools">
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table class="table table-hover text-nowrap table-sm">
                        <thead style="background-color:#3d8b99;">
                            <tr class="text-white">
                                <th style="border: 1px solid rgb(19, 19, 19)">No</th>
                                <th style="border: 1px solid rgb(19, 19, 19)">Bulan - Tahun</th>
                                <th style="border: 1px solid rgb(19, 19, 19)">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td style="border: 1px solid rgb(19, 19, 19)">{{$key + 1}}</td>
                                <td style="border: 1px solid rgb(19, 19, 19)">{{$item->bulan}} {{$item->tahun}}</td>
                                <td style="border: 1px solid rgb(19, 19, 19)">
                                    <a href="/superadmin/pajakter/{{$item->id}}/skpd" class="btn btn-sm btn-info"><i
                                            class="fa fa-eye"></i> Detail</a>
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