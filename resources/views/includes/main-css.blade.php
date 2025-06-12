{{-- resources/views/includes/main-css.blade.php --}}

<!-- Dropzone CSS -->
<link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">

<!-- CoreUI CSS and your app styles with Vite -->
@vite('resources/sass/app.scss')

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-1.13.5/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/sl-1.7.0/datatables.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

{{-- Additional third-party stylesheets if any --}}
@yield('third_party_stylesheets')

{{-- Page-specific CSS pushed via @push --}}
@stack('page_css')

{{-- Livewire Styles --}}
@livewireStyles

<style>
    /* DataTables length select */
    div.dataTables_wrapper div.dataTables_length select {
        width: 65px;
        display: inline-block;
    }
    /* Select2 styles */
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
        background-color: #fff;
        border: 1px solid #D8DBE0;
        border-radius: 4px;
    }
    .select2-container .select2-selection--multiple,
    .select2-container .select2-selection--single {
        height: 35px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        margin-top: 2px;
    }
</style>
