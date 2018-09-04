@extends('layouts.app')

@section('content')
<p>Date: <input type="text" id="datepicker"></p>
@endsection

@push('scripts')
<script>
    $(function() {
        $("#datepicker").datepicker();
    });
</script>
@endpush
