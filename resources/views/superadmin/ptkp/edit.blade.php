@extends('layouts.user')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Data PTKP</h3>
                    <div class="card-tools">
                        <a href="/superadmin/ptkp" class="btn btn-sm btn-warning">Kembali</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="/superadmin/ptkp/edit/{{$data->id}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="text" name="nip" class="form-control" required value="{{$data->nip}}"
                                placeholder="Masukkan NIP">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" required value="{{$data->nama}}"
                                placeholder="Masukkan Nama">
                        </div>
                        <div class="form-group">
                            <label>PTKP</label>
                            <select name="ptkp" class="form-control" required>
                                <option value="">Pilih PTKP</option>
                                <option value="K/0" {{ $data->ptkp == 'K/0' ? 'selected' : '' }}>K/0</option>
                                <option value="K/1" {{ $data->ptkp == 'K/1' ? 'selected' : '' }}>K/1</option>
                                <option value="K/2" {{ $data->ptkp == 'K/2' ? 'selected' : '' }}>K/2</option>
                                <option value="K/3" {{ $data->ptkp == 'K/3' ? 'selected' : '' }}>K/3</option>
                                <option value="TK/0" {{ $data->ptkp == 'TK/0' ? 'selected' : '' }}>TK/0</option>
                                <option value="TK/1" {{ $data->ptkp == 'TK/1' ? 'selected' : '' }}>TK/1</option>
                                <option value="TK/2" {{ $data->ptkp == 'TK/2' ? 'selected' : '' }}>TK/2</option>
                                <option value="TK/3" {{ $data->ptkp == 'TK/3' ? 'selected' : '' }}>TK/3</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
@endsection