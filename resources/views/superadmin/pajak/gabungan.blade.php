@extends('layouts.user')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Bulan - Tahun</label>
                        <select name="bulan_tahun_id" id="bulan_tahun_id" class="form-control">
                            <option value="">-- Pilih Bulan Tahun --</option>
                            @foreach ($bulantahun as $item)
                            <option value="{{ $item->id }}">{{ $item->bulan }} {{ $item->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>SKPD</label>
                        <select name="skpd_id" id="skpd_id" class="form-control">
                            <option value="">---Semua SKPD---</option>
                            @foreach ($skpd as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-primary btn-block" onclick="filterData()">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Pajak Gabungan</h3>

                <div class="card-tools">
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-hover text-nowrap table-sm">
                    <thead style="background-color:#3d8b99;">
                        <tr class="text-white">
                            <th style="border: 1px solid rgb(19, 19, 19)">No</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">NIP</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Nama</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Pajak Terutang</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>


@endsection


@push('js')
<script>
    function filterData() {
        var bulan_tahun_id = $('#bulan_tahun_id').val();
        var skpd_id = $('#skpd_id').val();
        
        $.ajax({
            url: '/superadmin/pajakgabungan/get-data',
            type: 'GET',
            data: {
                bulan_tahun_id: bulan_tahun_id,
                skpd_id: skpd_id
            },
            success: function(response) {
                var html = '';
                if (response.success && response.data.length > 0) {
                    $.each(response.data, function(index, item) {
                        html += '<tr>';
                        html += '<td style="border: 1px solid rgb(19, 19, 19)">' + (index + 1) + '</td>';
                        html += '<td style="border: 1px solid rgb(19, 19, 19)">' + item.nip + '</td>';
                        html += '<td style="border: 1px solid rgb(19, 19, 19)">' + item.nama + '</td>';
                        html += '<td style="border: 1px solid rgb(19, 19, 19)">' + (item.pph_terutang ? parseFloat(item.pph_terutang).toLocaleString('id-ID') : '0') + '</td>';
                        html += '</tr>';
                    });
                } else {
                    html += '<tr><td colspan="4" class="text-center">Tidak ada data</td></tr>';
                }
                $('tbody').html(html);
            },
            error: function() {
                alert('Gagal mengambil data');
            }
        });
    }
</script>
@endpush