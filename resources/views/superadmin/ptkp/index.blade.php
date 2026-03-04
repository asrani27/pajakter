@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data PTKP</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm"
                            style="width: 250px; margin-right: 10px; display: inline-flex; align-items: center;">
                            <input type="text" name="search" id="search" class="form-control float-right"
                                placeholder="Cari NIP atau Nama...">
                        </div>
                        <a href="/superadmin/ptkp/create" class='btn btn-sm btn-primary'
                            style="display: inline-flex; align-items: center; margin-right: 5px;">Tambah Data</a>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table class="table table-hover text-nowrap table-sm table-bordered">
                        <thead class="bg-primary">
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>PTKP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($data as $key => $item)
                            <tr style="font-size:14px">
                                <td class="original-no">{{$data->firstItem() + $key}}</td>
                                <td>{{$item->nip}}</td>
                                <td>{{$item->nama}}</td>
                                <td>{{$item->ptkp}}</td>
                                <td class="text-right">
                                    <a href="/superadmin/ptkp/edit/{{$item->id}}" class="btn btn-sm btn-success"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="/superadmin/ptkp/delete/{{$item->id}}" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin dihapus?');"><i
                                            class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $data->appends(request()->except('page'))->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data PTKP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/superadmin/ptkp/import" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Pilih File Excel (.xlsx, .xls)</label>
                        <input type="file" class="form-control-file" id="file" name="file" accept=".xlsx,.xls,.csv"
                            required>
                        <small class="form-text text-muted">
                            Pastikan file Excel memiliki format:<br>
                            - Kolom B: NIP<br>
                            - Kolom C: Nama<br>
                            - Kolom D: PTKP
                        </small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        // AJAX Search
        $('#search').on('keyup', function() {
            var keyword = $(this).val();
            
            if (keyword.length >= 1) {
                $.ajax({
                    url: '/superadmin/ptkp/search',
                    method: 'GET',
                    data: { keyword: keyword },
                    dataType: 'json',
                    success: function(response) {
                        var tableBody = $('#tableBody');
                        tableBody.empty();
                        
                        if (response.data.length > 0) {
                            $.each(response.data, function(index, item) {
                                var row = '<tr style="font-size:14px">';
                                row += '<td>' + (index + 1) + '</td>';
                                row += '<td>' + item.nip + '</td>';
                                row += '<td>' + item.nama + '</td>';
                                row += '<td>' + item.ptkp + '</td>';
                                row += '<td class="text-right">';
                                row += '<a href="/superadmin/ptkp/edit/' + item.id + '" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>';
                                row += '<a href="/superadmin/ptkp/delete/' + item.id + '" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin ingin dihapus?\');"><i class="fa fa-trash"></i></a>';
                                row += '</td>';
                                row += '</tr>';
                                tableBody.append(row);
                            });
                        } else {
                            tableBody.append('<tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            } else {
                // Reload page if search is cleared
                location.reload();
            }
        });
    });
</script>
@endpush
@endsection