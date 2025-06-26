    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>@yield('title', config('app.name'))</title>
        <meta content="Fahim Anzam Dip" name="author">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="icon" href="{{ asset('images/favicon.png') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <style>
            @font-face {
                font-family: 'KhmerOS_battambang';
                src: url('{{ asset(' fonts/KhmerOS_battambang.ttf') }}') format('truetype');
                font-weight: normal;
                font-style: normal;
            }

            body,
            .c-header,
            .c-subheader,
            .navbar-brand,
            .c-header-nav,
            .breadcrumb,
            .c-main,
            .btn,
            .table,
            .form-control,
            .custom-select,
            .c-footer,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-family: 'KhmerOS_battambang', sans-serif;
            }

            body {
                font-weight: 400;
                line-height: 1.6;
                color: #333;
            }

            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-weight: 700;
                margin-top: 0;
                margin-bottom: 0.75rem;
            }

            .c-header,
            .c-subheader,
            .btn {
                font-weight: 600;
            }
        </style>

        @include('includes.main-css')
    </head>


    <body class="c-app">
        @include('layouts.sidebar')

        <div class="c-wrapper">
            <header class="c-header c-header-light c-header-fixed">
                @include('layouts.header')
                <div class="c-subheader justify-content-between px-3">
                    @yield('breadcrumb')
                </div>
            </header>

            <div class="c-body">
                <main class="c-main">
                    @yield('content')
                </main>
            </div>

            @include('layouts.footer')
        </div>

        @include('includes.main-js')
    </body>

    </html>