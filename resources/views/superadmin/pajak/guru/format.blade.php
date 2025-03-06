@if (Auth::user()->roles == 'superadmin')
<a href="/superadmin/pajakter/{{$id}}/skpd" class="btn btn-default"><i class="fa fa-arrow-left"></i>
    Kembali
</a>
@else

<a href="/admin" class="btn btn-default"><i class="fa fa-arrow-left"></i>
    Kembali
</a>
@endif
<a href="/excel/PENGAWAS_TK.xlsx" target="_blank" class="btn btn-success  btn-flat">Template Pengawas & TK</a>
<a href="/excel/GURU_SD.xlsx" target="_blank" class="btn btn-success btn-flat">Template Guru SD</a>
<a href="/excel/GURU_SMP.xlsx" target="_blank" class="btn btn-success  btn-flat">Template Guru SMP</a>
<a href="/excel/GURU_TEKNIS.xlsx" target="_blank" class="btn btn-success  btn-flat">Template Guru TEKNIS</a>