@extends('layouts.user')
@push('css')

@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <br />

        @include('dpd.rfk.detail.menu')

        <br /> <br />

        <div class="card">
            <div class="card-header text-center">
                <h5 class="card-titl text-bold"> DPW PPNI PROVINSI KALSEL<br />
                    DAFTAR AKUN/COA (CHART OF ACCOUNT)</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm" style="border: 1px solid black;">
                    <thead>
                        <tr style="font-size:12px" class="bg-warning" style="border: 1px solid black;">
                            <th style="border: 1px solid black; text-align:center">No</th>
                            <th style="border: 1px solid black; text-align:center">KODE AKUN</th>
                            <th style="border: 1px solid black; text-align:center">NAMA AKUN</th>
                            <th style="border: 1px solid black; text-align:center">PENJELASAN UMUM</th>
                            <th style="border: 1px solid black; text-align:center">PENJELASAN KHUSUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (coa() as $key => $item)
                        <tr style="font-size:12px">
                            <td style="border: 1px solid black;">{{$key +1}}</td>
                            <td style="border: 1px solid black;">{{$item->kode}}</td>
                            <td style="border: 1px solid black;">{{$item->nama}}</td>
                            <td style="border: 1px solid black;">{{$item->umum}}</td>
                            <td style="border: 1px solid black;">{{$item->khusus}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')

@endpush