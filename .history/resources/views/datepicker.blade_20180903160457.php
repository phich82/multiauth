@extends('layouts.app')

@section('content')
<p>Date: <input type="text" id="datepicker"></p>
@endsection

@push('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@push('scripts')
{{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
<script>
    $(function() {
        $("#datepicker").click(function (e) {
            alert(1);
        });
        console.log($("#datepicker").datepicker);
    });
</script>
@endpush
