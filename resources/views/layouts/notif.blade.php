@if (Session::get('success'))
iziToast.success({
title: 'Success',
message: '{{Session::get('success')}}',
position: 'topRight',
});
@endif

@if (Session::get('warning'))
iziToast.warning({
title: 'Warning',
message: '{{Session::get('warning')}}',
position: 'topRight',
});
@endif

@if (Session::get('info'))
iziToast.info({
title: 'Info',
message: '{{Session::get('info')}}',
position: 'topRight',
});
@endif

@if (Session::get('error'))
iziToast.error({
title: 'Error',
message: '{{Session::get('error')}}',
position: 'topRight',
});
@endif