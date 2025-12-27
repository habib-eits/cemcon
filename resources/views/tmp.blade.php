<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- ===== CSS ===== -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">

    <!-- Plugins CSS -->
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notyf/3.10.0/notyf.min.css" integrity="sha512-ZX18S8AwqoIm9QCd1EYun82IryFikdJt7lxj6583zx5Rvr5HoreO9tWY6f2VhSxvK+48vYFSf4zFtX/t2ge62g==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
/* Select2 Large (Bootstrap-like) */
.select2-container--default .select2-selection--single {
    height: 36px;
    padding: 6px 1px;
    font-size:12px;
    color: #495057;
    border: 1px solid #ced4da;
    
    
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 24px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 34px;
    width: 29px;
}
</style>
<style>
    /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none; /* Removes the button entirely in WebKit browsers */
  margin: 0; /* Ensures no extra margin remains */
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield; /* Hides the spinner in Firefox */
  appearance: textfield; /* Standard property for newer Firefox versions */
}

/* General standard (optional, but good practice) */
input[type=number] {
  appearance: none;
}
</style>
</head>

<body data-sidebar="dark">

<div id="layout-wrapper">

    @include('template.header')
    @include('template.sidebar')

   

</div>

<div class="rightbar-overlay"></div>

<!-- ===== JAVASCRIPT ===== -->

<!-- jQuery (ONLY ONCE) -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>

<!-- Core plugins -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

<!-- Plugins -->
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/toastr/build/toastr.min.js') }}"></script>

<!-- App -->
<script src="{{ asset('assets/js/app.js') }}"></script>

<!-- ===== PAGE SCRIPTS ===== -->
<script>
$(document).ready(function () {

    /* Select2 */
    $('.select2').select2({
        width: '100%'
    });

    /* Auto focus search field */
    $(document).on('select2:open', function () {
        document.querySelector('.select2-search__field')?.focus();
    });

    /* Success alert */
    $('#success-alert').fadeTo(4000, 500).slideUp(500, function () {
        $(this).alert('close');
    });

});
</script>
 <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        // Create an instance of Notyf
        let notyf = new Notyf({
            duration: 3000,
            position: {
                x: 'right',
                y: 'top',
            },
        });
    </script>
 <div class="">
        @yield('content')
        @include('template.footer')
    </div>

</body>
</html>
