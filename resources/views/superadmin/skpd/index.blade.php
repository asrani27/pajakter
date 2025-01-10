@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
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
                                <th style="border: 1px solid rgb(19, 19, 19)">Kode</th>
                                <th style="border: 1px solid rgb(19, 19, 19)">Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($skpd as $key => $item)
                            <tr>
                                <td style="border: 1px solid rgb(19, 19, 19)">{{$key + 1}}</td>
                                <td style="border: 1px solid rgb(19, 19, 19)">{{$item->kode}}</td>
                                <td style="border: 1px solid rgb(19, 19, 19)">{{$item->nama}}</td>
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