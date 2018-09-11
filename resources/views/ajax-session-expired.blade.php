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
<script src="{{ asset('js/ajax-session-expired.js') }}"></script>
<script>
    //var $_ = jQuery.noConflict(); // use if previous jquery used
    $(function () {
        var data = {
            email: 'test@gmail.com',
            password: '123456',
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
                url: "{{ route('ajax-session-expired') }}",
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (data, status, xhr) {
                    console.log(data);
                    console.log(xhr);
                }
            })
            .fail(function (jqXHR) {
                console.log(jqXHR.responseJSON);
            });
    });

</script>
@endpush
