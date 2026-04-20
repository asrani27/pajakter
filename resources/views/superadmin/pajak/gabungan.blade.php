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
                            <th style="border: 1px solid rgb(19, 19, 19)" class="text-right">Pajak TPP</th>
                            <th style="border: 1px solid rgb(19, 19, 19)" class="text-right">Pajak THR</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot style="background-color:#e9ecef;font-weight:bold;">
                        <tr>
                            <td colspan="3" style="border: 1px solid rgb(19, 19, 19)">Total Pajak Terutang</td>
                            <td style="border: 1px solid rgb(19, 19, 19)" class="text-right" id="total_pajak">0</td>
                            <td style="border: 1px solid rgb(19, 19, 19)" class="text-right" id="total_thr">0</td>
                        </tr>
                    </tfoot>
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
                var total = 0;
                var total_thr = 0;
                if (response.success && response.data.length > 0) {
                    $.each(response.data, function(index, item) {
                        var pph = item.pph_terutang ? parseFloat(item.pph_terutang) : 0;
                        var pph_thr = item.pph_thr ? parseFloat(item.pph_thr) : 0;
                        total += pph;
                        total_thr += pph_thr;
                        html += '<tr>';
                        html += '<td style="border: 1px solid rgb(19, 19, 19)">' + (index + 1) + '</td>';
                        html += '<td style="border: 1px solid rgb(19, 19, 19)">' + item.nip + '</td>';
                        html += '<td style="border: 1px solid rgb(19, 19, 19)">' + item.nama + '</td>';
                        html += '<td style="border: 1px solid rgb(19, 19, 19)">' + pph.toLocaleString('id-ID') + '</td>';
                        html += '<td style="border: 1px solid rgb(19, 19, 19)">' + pph_thr.toLocaleString('id-ID') + '</td>';
                        html += '</tr>';
                    });
                } else {
                    html += '<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>';
                }
                $('tbody').html(html);
                $('#total_pajak').text(total.toLocaleString('id-ID'));
                $('#total_thr').text(total_thr.toLocaleString('id-ID'));
            },
            error: function() {
                alert('Gagal mengambil data');
            }
        });
    }
</script>
@endpush