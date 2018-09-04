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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    //var $_ = jQuery.noConflict(); // use if previous jquery used
    $(function() {
        $("#datepicker").datepicker({
            onChangeMonthYear: function (year, month, dp) {
                this.beforeShow(null, dp);
            },
            beforeShow: function(input, dp) {
                setTimeout(function() {
                    var contentCells = {
                        '201809': 'Holiday'
                    };
                    console.log(contentCells);
                }, 0);
            }
        });
    });
</script>
@endpush
