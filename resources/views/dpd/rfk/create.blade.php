@extends('layouts.user')
@push('css')

@endpush
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br />
            <a href="/dpd/rfk" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left"></i>
                Kembali
            </a><br /><br />
            <div class="card">
                <div class="card-header" style="cursor: move;">

                    <h3 class="card-title">
                        <i class="fa fa-list"></i>
                        Tambah Data
                    </h3>
                    <div class="card-tools">

                    </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="post" action="/dpd/rfk/create">
                        @csrf
                        <div class="form-group">
                            <label>Nama Kab/Kota</label>
                            <input type="text" class="form-control" value="{{Auth::user()->name}}" name="nama">
                        </div>
                        <div class="form-group">
                            <label>Kondisi Tanggal</label>
                            <input type="date" class="form-control" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}"
                                name="kondisi">
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> SIMPAN</button>

                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')

@endpush