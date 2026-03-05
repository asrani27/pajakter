@extends('layouts.user')

@section('content')
<div class="row">

    <div class="col-12">
        <a href="/superadmin/pajakter/create-bulan-tahun" class="btn btn-sm btn-default"><i
                class="fa fa-plus-circle"></i>
            Tambah
            Data</a><br /><br />
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Pajak TER</h3>

                <div class="card-tools">
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-hover text-nowrap table-sm">
                    <thead style="background-color:#3d8b99;">
                        <tr class="text-white">
                            <th style="border: 1px solid rgb(19, 19, 19)">No</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Bulan - Tahun</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Gaji Utk TPP</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Gaji Utk BPJS</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">PPPK</th>
                            <th style="border: 1px solid rgb(19, 19, 19)">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                        <tr>
                            <td style="border: 1px solid rgb(19, 19, 19)">{{$key + 1}}</td>
                            <td style="border: 1px solid rgb(19, 19, 19)">{{$item->bulan}} {{$item->tahun}}</td>

                            <td style="border: 1px solid rgb(19, 19, 19)">
                                <form method="post" action="/superadmin/pajakter/gajitpp/{{$item->id}}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" class="form-control-sm" name="file" required>
                                    <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-upload"></i>
                                        Upload</button>
                                </form>
                            </td>
                            <td style="border: 1px solid rgb(19, 19, 19)">
                                <form method="post" action="/superadmin/pajakter/gajibpjs/{{$item->id}}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" class="form-control-sm" name="file" required>
                                    <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-upload"></i>
                                        Upload</button>
                                </form>
                            </td>
                            <td style="border: 1px solid rgb(19, 19, 19)">
                                <a href="/superadmin/pajakter/{{$item->id}}/pppk-pajak"
                                    class="btn btn-xs btn-success"><i class="fa fa-eye"></i> PAJAK</a>
                                <a href="/superadmin/pajakter/{{$item->id}}/pppk-bpjs" class="btn btn-xs btn-success"><i
                                        class="fa fa-eye"></i> BPJS</a>
                            </td>
                            <td style="border: 1px solid rgb(19, 19, 19)">
                                <a href="/superadmin/pajakter/{{$item->id}}/updateptkp" class="btn btn-sm btn-primary">
                                    <i class="fa fa-list"></i> Update PTKP
                                </a>
                                <a href="/superadmin/pajakter/{{$item->id}}/skpd" class="btn btn-sm btn-info"><i
                                        class="fa fa-eye"></i> Detail</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<!-- Progress Modal -->
<div class="modal fade" id="progressModal" tabindex="-1" role="dialog" aria-labelledby="progressModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="progressModalLabel">Update PTKP Progress</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeProgressModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="progress mb-3">
                    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                        role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        0%
                    </div>
                </div>
                <div id="progressMessage" class="text-center mb-3">
                    Memulai proses...
                </div>
                <div class="text-center">
                    <small class="text-muted">
                        <span id="processedCount">0</span> / <span id="totalCount">0</span> data
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeProgressBtn"
                    disabled>Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    let progressInterval;

    function startPtkpUpdate(id) {
        // Disable button
        $('.btn-update-ptkp[data-id="' + id + '"]').prop('disabled', true);
        $('.btn-update-ptkp[data-id="' + id + '"]').html('<i class="fa fa-spinner fa-spin"></i> Memulai...');

        // Show modal
        $('#progressModal').modal('show');
        $('#progressBar').css('width', '0%');
        $('#progressBar').attr('aria-valuenow', 0);
        $('#progressBar').text('0%');
        $('#progressMessage').text('Memulai update PTKP...');
        $('#processedCount').text('0');
        $('#totalCount').text('0');
        $('#closeProgressBtn').prop('disabled', true);

        // Start the update process
        $.get('{{ url("/superadmin/pajakter") }}/' + id + '/updateptkp', function(response) {
            // Start checking progress
            checkProgress(id);
        }).fail(function() {
            $('#progressMessage').text('Gagal memulai proses update');
            $('#progressBar').removeClass('progress-bar-success').addClass('progress-bar-danger');
            $('#closeProgressBtn').prop('disabled', false);
        });
    }

    function checkProgress(id) {
        progressInterval = setInterval(function() {
            $.get('{{ url("/superadmin/pajakter") }}/' + id + '/check-ptkp-progress', function(data) {
                if (data.status === 'processing') {
                    // Update progress
                    const percentage = data.percentage.toFixed(2);
                    $('#progressBar').css('width', percentage + '%');
                    $('#progressBar').attr('aria-valuenow', percentage);
                    $('#progressBar').text(percentage + '%');
                    $('#progressMessage').text(data.message);
                    $('#processedCount').text(data.processed);
                    $('#totalCount').text(data.total);
                } else if (data.status === 'completed') {
                    // Completed successfully
                    clearInterval(progressInterval);
                    $('#progressBar').css('width', '100%');
                    $('#progressBar').attr('aria-valuenow', 100);
                    $('#progressBar').text('100%');
                    $('#progressBar').removeClass('progress-bar-striped progress-bar-animated')
                        .addClass('progress-bar-success');
                    $('#progressMessage').text(data.message);
                    $('#processedCount').text(data.processed);
                    $('#totalCount').text(data.total);
                    $('#closeProgressBtn').prop('disabled', false);

                    // Re-enable button
                    $('.btn-update-ptkp[data-id="' + id + '"]').prop('disabled', false);
                    $('.btn-update-ptkp[data-id="' + id + '"]').html('<i class="fa fa-list"></i> Update PTKP');

                    // Show success notification
                    alert('Update PTKP berhasil diselesaikan!');
                } else if (data.status === 'failed') {
                    // Failed
                    clearInterval(progressInterval);
                    $('#progressBar').removeClass('progress-bar-striped progress-bar-animated')
                        .addClass('progress-bar-danger');
                    $('#progressMessage').text(data.message);
                    $('#closeProgressBtn').prop('disabled', false);

                    // Re-enable button
                    $('.btn-update-ptkp[data-id="' + id + '"]').prop('disabled', false);
                    $('.btn-update-ptkp[data-id="' + id + '"]').html('<i class="fa fa-list"></i> Update PTKP');

                    // Show error notification
                    alert('Update PTKP gagal: ' + data.message);
                } else if (data.status === 'not_started') {
                    $('#progressMessage').text('Menunggu proses dimulai...');
                }
            }).fail(function() {
                clearInterval(progressInterval);
                $('#progressMessage').text('Gagal mengambil progress');
                $('#progressBar').removeClass('progress-bar-striped progress-bar-animated')
                    .addClass('progress-bar-danger');
                $('#closeProgressBtn').prop('disabled', false);

                // Re-enable button
                $('.btn-update-ptkp[data-id="' + id + '"]').prop('disabled', false);
                $('.btn-update-ptkp[data-id="' + id + '"]').html('<i class="fa fa-list"></i> Update PTKP');
            });
        }, 1000); // Check every 1 second
    }

    // Close modal handler
    $('#closeProgressModal, #closeProgressBtn').on('click', function() {
        if ($('#closeProgressBtn').prop('disabled') === false) {
            $('#progressModal').modal('hide');
            // Reset progress bar for next use
            setTimeout(function() {
                $('#progressBar').removeClass('progress-bar-success progress-bar-danger')
                    .addClass('progress-bar-striped progress-bar-animated');
                $('#progressBar').css('width', '0%');
                $('#progressBar').attr('aria-valuenow', 0);
                $('#progressBar').text('0%');
            }, 500);
        }
    });
</script>
@endpush

@endsection