@extends('layouts.app')

@section('content')
<p>Date: <input type="text" id="datepicker"></p>
@endsection

@push('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    //var $j = jQuery.noConflict();
    jQuery(function() {
        jQuery("#datepicker").datepicker();
    });
</script>
@endpush
