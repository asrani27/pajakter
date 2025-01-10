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
                    <a href="/superadmin/pajakter" class="btn btn-app bg-info">
                        <i class="fas fa-money-bill"></i> <strong>PAJAK TER</strong>
                    </a>
                    <a href="/superadmin/skpd" class="btn btn-app bg-info">
                        <i class="fas fa-university"></i> <strong>SKPD</strong>
                    </a>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
@endsection