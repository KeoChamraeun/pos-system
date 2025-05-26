<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timout:
    |
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
    */

    'pdf' => [
        'enabled' => true,
        //'binary'  => env('WKHTML_PDF_BINARY', base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),),
        'binary' => '"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe"',
        'timeout' => false,
        'options' => [
            'enable-local-file-access' => true,
            'print-media-type' => true
        ],
        'env'     => [],
    ],

    'image' => [
        'enabled' => true,
        'binary'  => env('WKHTML_PDF_BINARY'),
        'timeout' => false,
        'options' => [
            'enable-local-file-access' => true
        ],
        'env'     => [],
    ],

    'pdf' => [
        'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"', // adjust to Linux path if hosted on Linux
        'options' => [
            'enable-local-file-access' => true, // required for loading local assets (CSS/fonts)
            'encoding' => 'UTF-8',              // important for Unicode
            'no-outline' => true,
            'viewport-size' => '1280x1024',
            'load-error-handling' => 'ignore',
            'load-media-error-handling' => 'ignore',
        ],
    ],


    'image' => [
        'enabled' => true,
        'binary'  => '/usr/bin/wkhtmltoimage', // Optional: for image rendering
        'timeout' => false,
        'options' => [
            'enable-local-file-access' => true
        ],
        'env'     => [],
    ],


];
