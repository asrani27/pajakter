@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Data</h3>

            </div>
            <form method="POST" action="/superadmin/user/edit/{{$data->id}}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">NAMA INSTANSI</label>
                        <input type="text" name="name" class="form-control" required placeholder="nama"
                            value="{{$data->name}}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">username (utk Login)</label>
                        <input type="text" id="input1" name="username" class="form-control no-space" readonly
                            placeholder="username" value="{{$data->username}}">
                        @error('username')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="text" id="input2" name="password1" class="form-control no-space"
                            placeholder="password">
                        <small>kosongkan password jika tidak diganti</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Masukkan Password Lagi</label>
                        <input type="text" id="input3" name="password2" class="form-control no-space"
                            placeholder="masukkan password lagi">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Roles</label>
                        <select name="roles" class="form-control" required>
                            <option value="">-pilih-</option>
                            <option value="dpw" {{$data->roles == 'dpw' ? 'selected':''}}>DPW</option>
                            <option value="dpd" {{$data->roles == 'dpd' ? 'selected':''}}>DPD</option>
                            <option value="dpk" {{$data->roles == 'dpk' ? 'selected':''}}>DPK</option>
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
    // Ambil elemen input
    const noSpaceInputs = document.querySelectorAll('.no-space');

    // Tambahkan event listener untuk menghapus spasi
    noSpaceInputs.forEach(input => {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/\s/g, ''); // Hapus semua spasi
            });
        });
</script>
@endpush