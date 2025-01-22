<div class="btn-group">
    <a href="#" class="btn btn-flat btn-danger">PAJAK</a>
    <a href="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/guru"
        class="btn btn-flat {{request()->is('superadmin/pajakter/'.$id.'/skpd/'.$skpd_id.'/guru') ? 'btn-primary':'btn-outline-primary'}}">PENGAWAS
        & GURU
        TK</a>
    <a href="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/gurusd"
        class="btn btn-flat {{request()->is('superadmin/pajakter/'.$id.'/skpd/'.$skpd_id.'/gurusd') ? 'btn-primary':'btn-outline-primary'}}">GURU
        SD</a>
    <a href="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/gurusmp"
        class="btn btn-flat {{request()->is('superadmin/pajakter/'.$id.'/skpd/'.$skpd_id.'/gurusmp') ? 'btn-primary':'btn-outline-primary'}}">GURU
        SMP</a>
    <a href="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/guruteknis"
        class="btn btn-flat {{request()->is('superadmin/pajakter/'.$id.'/skpd/'.$skpd_id.'/guruteknis') ? 'btn-primary':'btn-outline-primary'}}">GURU
        P3K & TEKNIS</a>
</div>

<div class="btn-group">
    <a href="#" class="btn btn-flat btn-success">BPJS</a>
    <a href="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/guru/bpjs"
        class="btn btn-flat {{request()->is('superadmin/pajakter/'.$id.'/skpd/'.$skpd_id.'/guru/bpjs') ? 'btn-primary':'btn-outline-primary'}}">PENGAWAS
        & GURU
        TK</a>
    <a href="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/gurusd/bpjs"
        class="btn btn-flat {{request()->is('superadmin/pajakter/'.$id.'/skpd/'.$skpd_id.'/gurusd/bpjs') ? 'btn-primary':'btn-outline-primary'}}">GURU
        SD</a>
    <a href="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/gurusmp/bpjs"
        class="btn btn-flat {{request()->is('superadmin/pajakter/'.$id.'/skpd/'.$skpd_id.'/gurusmp/bpjs') ? 'btn-primary':'btn-outline-primary'}}">GURU
        SMP</a>
    <a href="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/guruteknis/bpjs"
        class="btn btn-flat {{request()->is('superadmin/pajakter/'.$id.'/skpd/'.$skpd_id.'/guruteknis/bpjs') ? 'btn-primary':'btn-outline-primary'}}">GURU
        P3K & TEKNIS</a>
</div>