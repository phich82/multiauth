@extends('layouts.app')

@section('content')
<div class="container">
    <button class="btn btn-primary" onclick="openPopup()">Open Popup</button><br/><br/>
    <button class="btn btn-secondary" onclick="exportExcel()">Export To Excel</button><br/><br/>
    <button class="btn btn-secondary" onclick="downloadExcel()">Download Excel</button>
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
<script src="{{ asset('js/dialog.js') }}"></script>
<script>
    // confirm before refresh or close or redirect to other page
    // window.onbeforeunload = function (e) {
    //     var message = popup.leave();
    //     e.returnValue = message;
    //     return message;
    // };




    refreshPageCheck();
    // notify when refreshing page by pressing F5
    function refreshPageCheck() {
        document.querySelector('body').onkeydown = function (e) {
            if (e.altKey && e.keyCode == 115) { // press ALT+F4 (close browser)
                e.preventDefault();
                return popup.confirm('Close Browser', 'Unsaved changes might be loss if closing browser?', function () {
                    window.location.reload();
                });
            }

            if (!e.metaKey && e.keyCode == 116) { // press F5 (refresh)
                e.preventDefault();
                return popup.confirm('Refesh Page', 'Unsaved changes might be loss if reloading page?', function () {
                    window.location.reload();
                });
            }
        }
    }

    function exportExcel() {
        window.location.href = "{{ route('export-excel') }}";
        // $.ajax({
        //     url: "{{ route('export-excel') }}",
        //     //dataType: 'json',
        //     success: function (data, status, xhr) {
        //         console.log(data);
        //         console.log(xhr);
        //     }
        // });
    }

    function downloadExcel() {
        window.location.href = "{{ route('download-excel') }}";
        // $.ajax({
        //     url: "{{ route('export-excel') }}",
        //     //dataType: 'json',
        //     success: function (data, status, xhr) {
        //         console.log(data);
        //         console.log(xhr);
        //     }
        // });
    }

    function openPopup() {
        var config = ['<i class="fa fa-exclamation-triangle" style="font-size:30px;" aria-hidden="true"></i> Header Title', 'This is test content', {ok: 'Yes', no: 'No'}];
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
        // popup.success('<i class="fa fa-exclamation-triangle" style="font-size:30px;" aria-hidden="true"></i>Saved successfully', '<div class="text-center">Success</div>', function () {
        //     popup.wait();
        //     popup.error('Error', 'Error', function () {
        //         popup.wait();
        //         popup.warning('Warning', 'Warning', function () {
        //             alert(3);
        //             popup.wait();
        //             popup.success('S4', 'S4');
        //         });
        //     });
        // });
        //popup.config(app.popup.timereport.success).success(function () {
        popup.success(app.popup.timereport.success, function () {
            popup.wait();
            popup.config(app.popup.timereport.error).error(function () {
                popup.wait();
                popup.config(app.popup.timereport.warning).warning(function () {
                    alert(3);
                    popup.wait();
                    popup.success('S4', 'It will redirect to Home page after closing this dialog.', function () {
                        //window.location.href = "{{ route('home') }}";
                        popup.wait();
                        //popup.config(app.popup.timereport.info).info();
                        popup.info(app.popup.timereport.info);
                    });
                });
            });
        });
        // popup.withIcon().config(app.popup.timereport.confirm).confirm('XXX', 'XXXXXXXX', function (){}, function () {
        //     alert(222);
        // }, function () {
        //     alert(000)
        // });
        // console.log(dialog);
        // dialog.success('Success', '<div class="text-center">Success</div>', function () {
        //     dialog.wait();
        //     dialog.error('Error', 'Error', function () {
        //         dialog.wait();
        //         dialog.warning('Warning', 'Warning', function () {
        //             alert(3);
        //             dialog.wait();
        //             dialog.success('S4', 'S4');
        //         });
        //     });
        // });
    }
</script>
@endpush
