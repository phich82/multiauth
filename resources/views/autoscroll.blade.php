@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <select class="select_migration">
            <option>Please select one...</option>
            <option>A</option>
            <option>B</option>
            <option>C</option>
        </select>
    </div>
    <div class="row">
        <h1>HISTORY, PURPOSE AND USAGE</h1>
        <p>
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero's De Finibus Bonorum et Malorum for use in a type specimen book. It usually begins with:
        </p>
        <p>
            “Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.”
            The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn't distract from the layout. A practice not without controversy, laying out pages with meaningless filler text can be very useful when the focus is meant to be on design, not content.
        </p>
        <p>
            The passage experienced a surge in popularity during the 1960s when Letraset used it on their dry-transfer sheets, and again during the 90s as desktop publishers bundled the text with their software. Today it's seen all around the web; on templates, websites, and stock designs. Use our generator to get your own, or read on for the authoritative history of lorem ipsum.
        </p>
    </div>
    <div class="row">
        <h1>HISTORY, PURPOSE AND USAGE</h1>
        <p>
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero's De Finibus Bonorum et Malorum for use in a type specimen book. It usually begins with:
        </p>
        <p>
            “Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.”
            The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn't distract from the layout. A practice not without controversy, laying out pages with meaningless filler text can be very useful when the focus is meant to be on design, not content.
        </p>
        <p>
            The passage experienced a surge in popularity during the 1960s when Letraset used it on their dry-transfer sheets, and again during the 90s as desktop publishers bundled the text with their software. Today it's seen all around the web; on templates, websites, and stock designs. Use our generator to get your own, or read on for the authoritative history of lorem ipsum.
        </p>
    </div>
    <div class="row">
        <input type="text" name="first_name" class="error" /><br/>
        <p class="alert alert-danger">Please enter a valid first name.</p>
    </div>
    <div class="row">
        <input type="text" name="last_name" class="error" /><br/>
        <p class="alert alert-danger">Please enter a valid last name.</p>
    </div>
    <div class="row">
        <h1>HISTORY, PURPOSE AND USAGE</h1>
        <p>
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero's De Finibus Bonorum et Malorum for use in a type specimen book. It usually begins with:
        </p>
        <p>
            “Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.”
            The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn't distract from the layout. A practice not without controversy, laying out pages with meaningless filler text can be very useful when the focus is meant to be on design, not content.
        </p>
        <p>
            The passage experienced a surge in popularity during the 1960s when Letraset used it on their dry-transfer sheets, and again during the 90s as desktop publishers bundled the text with their software. Today it's seen all around the web; on templates, websites, and stock designs. Use our generator to get your own, or read on for the authoritative history of lorem ipsum.
        </p>
    </div>
    <div class="row">
        <h1>HISTORY, PURPOSE AND USAGE</h1>
        <p>
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero's De Finibus Bonorum et Malorum for use in a type specimen book. It usually begins with:
        </p>
        <p>
            “Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.”
            The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn't distract from the layout. A practice not without controversy, laying out pages with meaningless filler text can be very useful when the focus is meant to be on design, not content.
        </p>
        <p>
            The passage experienced a surge in popularity during the 1960s when Letraset used it on their dry-transfer sheets, and again during the 90s as desktop publishers bundled the text with their software. Today it's seen all around the web; on templates, websites, and stock designs. Use our generator to get your own, or read on for the authoritative history of lorem ipsum.
        </p>
    </div>
    <div class="row">
        <select class="domain_migration_status">
            <option>Please select one...</option>
            <option>A</option>
            <option>B</option>
            <option>C</option>
        </select>
    </div>
    <div class="row text-center">
        <button class="btn btn-primary btn-submit">Submit</button>
    </div>
</div>
@endsection

@push('styles')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
@endpush

@push('scripts')
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="{{ asset('js/popup.js') }}"></script>
<script src="{{ asset('js/dialog.js') }}"></script>
<script>
    $(function () {
        $(document).on('change', '.domain_migration_status', function () {
            scrollTo('.select_migration');
        });

        $('.btn-submit').click(function () {
            scrollTo($('.error').first());
        })
    });

    function scrollTo(identity, speed) {
        var elementTarget = null;
        if (typeof identity === 'string') {
            elementTarget = $(identity);
        } else if (typeof identity === 'object') {
            elementTarget = identity;
        }

        if (elementTarget && elementTarget.length) { // exist
            speed = typeof speed === 'number' ? speed : 500;
            $('html, body').animate({
                scrollTop: elementTarget.offset().top //$('.error').first().offset().top
            }, speed);
            elementTarget.focus();
        }
    }
</script>
@endpush
