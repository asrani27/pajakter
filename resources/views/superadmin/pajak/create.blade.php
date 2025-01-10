@extends('layouts.user')
@push('css')

@endpush
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <a href="/superadmin/pajakter" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>
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
                    <form method="post" action="/superadmin/pajakter/create-bulan-tahun">
                        @csrf
                        <div class="form-group">
                            <label>Bulan</label>
                            <select class="form-control" name="bulan" required>
                                @foreach (bulan() as $item)
                                <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="text" class="form-control" value="{{\Carbon\Carbon::now()->format('Y')}}"
                                name="tahun">
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