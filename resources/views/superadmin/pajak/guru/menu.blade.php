<div class="btn-group">

    <a href="/superadmin/pajakter/{{$id}}/skpd/{{$skpd_id}}/guru"
        class="btn btn-flat {{request()->is('superadmin/pajakter/'.$id.'/skpd/'.$skpd_id.'/guru') ? 'btn-primary':'btn-outline-primary'}}"><i
            class="fa fa-users"></i> PENGAWAS & GURU
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