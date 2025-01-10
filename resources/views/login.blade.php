@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 text-center">
        <img src="/logo/bpkpad.png" width="15%">
        <h2>PEKA ABPD KOTA BANJARMASIN</h2>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Masuk Aplikasi</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action='login' method="POST" class="form-horizontal">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="username" name="username" class="form-control" placeholder="Username"
                                autocomplete="new-password">
                            @error('username')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" placeholder="Password"
                                autocomplete="new-password">
                            @error('password')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Log in</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endsection