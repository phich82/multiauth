@extends('layouts.app')

@section('content')
<div class="container">
    <input type="text" class="form-control timepicker" name="time" />
</div>
@endsection

@push('styles')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css" />
<style>
    .ui-timepicker-wrapper {
        width: 65px;
    }
    .ui-timepicker-wrapper .ui-timepicker-list li:hover {
        background-color: orange;
    }
    table input {
        width: 100%;
    }
    table th {
        text-align: center;
    }
    table td {
        padding: 2px !important;
        height: 100%;
    }
    .error {
        color: red !important;
    }
    .error-border {
        border: 1px solid red !important;
    }
    .pointer,
    .cursor {
        cursor: pointer;
    }
    .no-border {
        border: 0 !important;
        box-shadow: none !important;
    }
    .w100 {
        width: 100px !important;
    }
    .w100p {
        width: 100% !important;
    }
    .h100p {
        height: 100% !important;
    }
</style>
@endpush
@push('scripts')
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
<script>
    $(function () {
        $(document).on('change', 'input.timepicker', function (e) {
            console.log(1);
        });

        $('input.timepicker').timepicker({timeFormat: 'H:i', step: 15, minTime: '00:00', maxTime: '23:00'}).val('08:30')
        .on('changeTime', function (timepicker) { // fire before 'change' event
            console.log($(timepicker.currentTarget).val());
        }).on('timeFormatError', function (timepicker) { // fire before 'change' event
            $(timepicker.currentTarget).val('');
        });
    });
</script>
@endpush
