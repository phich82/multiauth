@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <p>Date: <input type="text" id="datepicker"></p>
    </div>
</div>
<!-- step 1 -->
<input type="text" id="myDatepicker" placeholder="Click to pick date" />

<!-- step 2 -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<!-- step 3 -->
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>
/* step 5 */
$( "#myDatepicker" ).datepicker();
</script>
@endsection

@push('styles')
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/vader/jquery-ui.min.css" />
@endpush
