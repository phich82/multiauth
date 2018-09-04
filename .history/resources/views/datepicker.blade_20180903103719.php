@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <p>Date: <input type="text" id="datepicker"></p>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

</script>
@endpush
