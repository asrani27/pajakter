@extends('layouts.user')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Data PTKP</h3>
                    <div class="card-tools">
                        <a href="/superadmin/ptkp" class="btn btn-sm btn-warning">Kembali</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="/superadmin/ptkp/create" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="text" name="nip" class="form-control" required placeholder="Masukkan NIP">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" required placeholder="Masukkan Nama">
                        </div>
                        <div class="form-group">
                            <label>PTKP</label>
                            <select name="ptkp" class="form-control" required>
                                <option value="">Pilih PTKP</option>
                                <option value="K/0">K/0</option>
                                <option value="K/1">K/1</option>
                                <option value="K/2">K/2</option>
                                <option value="K/3">K/3</option>
                                <option value="TK/0">TK/0</option>
                                <option value="TK/1">TK/1</option>
                                <option value="TK/2">TK/2</option>
                                <option value="TK/3">TK/3</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
@endsection