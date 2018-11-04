@extends('layouts.app')

@section('content')
<div class="container">
    <button onclick="openPopup()">Open Popup</button>
</div>
@endsection
@include('partials.popup')
@push('styles')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
{{-- <link href="{{ asset('css/popup.css') }}" rel="stylesheet"> --}}
@endpush
@push('scripts')
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="{{ asset('js/popup.js') }}"></script>
<script>
    function openPopup() {
        var config = ['<i class="fa fa-exclamation-triangle" style="font-size:30px;" aria-hidden="true"></i> Header Title', 'This is test content', {ok: 'Yes', cancel: 'No'}];
        // popup.confirm(...config, function (element) {
        //     alert();
        //     popup.wait();
        //     popup.success('Success', 'Success', function () {
        //         popup.wait();
        //         popup.error('Error', 'Error', function () {
        //             popup.wait();
        //             popup.warning('Warning', 'Warning');
        //         });
        //     });
        // });
        popup.success('Success', '<div class="text-center">Success</div>', function () {
            popup.wait();
            popup.error('Error', 'Error', function () {
                popup.wait();
                popup.warning('Warning', 'Warning', function () {
                    alert(3);
                    popup.wait();
                    popup.success('S4', 'S4');
                });
            });
        });
    }
</script>
@endpush
