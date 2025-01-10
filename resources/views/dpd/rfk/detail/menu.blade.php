<a href="/dpd/rfk" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a><br /><br />
<div class="btn-group table-responsive" style="border: 1px solid rgb(145, 143, 143)">
    <a href="/dpd/rfk/detail/{{$id}}/akun"
        class="btn btn-default {{request()->is('dpd/rfk/detail/'.$id.'/akun*') ? 'bg-primary text-bold':''}}">AKUN</a>
    <a href="/dpd/rfk/detail/{{$id}}/okk"
        class="btn btn-default {{request()->is('dpd/rfk/detail/'.$id.'/okk*') ? 'bg-primary text-bold':''}}">1.
        RFK OKK</a>
    <a href="/dpd/rfk/detail/{{$id}}/hp"
        class="btn btn-default {{request()->is('dpd/rfk/detail/'.$id.'/hp*') ? 'bg-primary text-bold':''}}">2.
        RFK HP</a>
    <a href="/dpd/rfk/detail/{{$id}}/pp"
        class="btn btn-default {{request()->is('dpd/rfk/detail/'.$id.'/pp*') ? 'bg-primary text-bold':''}}">3.
        RFK PP</a>
    <a href="/dpd/rfk/detail/{{$id}}/kdln"
        class="btn btn-default {{request()->is('dpd/rfk/detail/'.$id.'/kdln*') ? 'bg-primary text-bold':''}}">4.
        RFK KDLN</a>
    <a href="/dpd/rfk/detail/{{$id}}/diklat"
        class="btn btn-default {{request()->is('dpd/rfk/detail/'.$id.'/diklat*') ? 'bg-primary text-bold':''}}">5.
        RFK DIKLAT</a>
    <a href="/dpd/rfk/detail/{{$id}}/penelitian"
        class="btn btn-default {{request()->is('dpd/rfk/detail/'.$id.'/penelitian*') ? 'bg-primary text-bold':''}}">6.
        RFK PENELITIAN</a>
    <a href="/dpd/rfk/detail/{{$id}}/sisinfokom"
        class="btn btn-default {{request()->is('dpd/rfk/detail/'.$id.'/sisinfokom*') ? 'bg-primary text-bold':''}}">7.
        RFK SISINFOKOM</a>
    <a href="/dpd/rfk/detail/{{$id}}/pelayanan"
        class="btn btn-default {{request()->is('dpd/rfk/detail/'.$id.'/pelayanan*') ? 'bg-primary text-bold':''}}">8.
        RFK PELAYANAN</a>
    <a href="/dpd/rfk/detail/{{$id}}/kesejahteraan"
        class="btn btn-default {{request()->is('dpd/rfk/detail/'.$id.'/kesejahteraan*') ? 'bg-primary text-bold':''}}">9.
        RFK KESEJAHTERAAN</a>
</div>