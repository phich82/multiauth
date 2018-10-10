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
        popup.confirm('Header Title', 'This is test content', {ok: 'Yes', cancel: 'No'}, function ok(element) {
            alert(element);
        });
    }
</script>
@endpush
