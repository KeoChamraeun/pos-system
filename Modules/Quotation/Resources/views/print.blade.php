<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Quotation Details') }}</title>
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
    <style>
        @font-face {
            font-family: 'KhmerOS';
            src: url('{{ public_path('fonts/KhmerOS_battambang.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        * {
            font-family: 'KhmerOS', 'Noto Sans Khmer', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
        }

        h2,
        h4 {
            font-size: 16px;
            margin: 0 0 10px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header img {
            max-width: 180px;
            height: auto;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-section {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px dashed #ddd;
        }

        th {
            background-color: #f5f5f5;
        }

        .summary-table {
            width: 50%;
            margin-left: auto;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            background-color: #28a745;
            color: white;
            border-radius: 3px;
            font-size: 10px;
        }

        .footer {
            text-align: center;
            font-style: italic;
            margin-top: 25px;
        }

        @media screen and (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .summary-table {
                width: 100%;
            }
        }

        @media print {
            body {
                padding: 0;
            }

            .info-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            th,
            td {
                padding: 5px;
            }

            .hidden-print {
                display: none !important;
            }

            .table,
            .summary-table {
                page-break-inside: auto;
            }

            .table tbody tr:last-child {
                page-break-after: avoid;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div style="text-align: center;margin-bottom: 25px;">
                <img width="180" src="{{ public_path('images/logo-dark.png') }}" alt="Logo">
                <h4 style="margin-bottom: 20px;">
                    <span>{{ __('Reference::') }}</span> <strong>{{ $quotation->reference }}</strong>
                </h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-xs-4 mb-3 mb-md-0">
                            <h4 class="mb-2" style="border-bottom: 1px solid #dddddd;padding-bottom: 10px;">Company Info:</h4>
                            <div><strong>{{ settings()->company_name }}</strong></div>
                            <div>{{ settings()->company_address }}</div>
                            <div>{{ __('Email') }}: {{ settings()->company_email }}</div>
                            <div>{{ __('Phone Number') }}: {{ settings()->company_phone }}</div>
                        </div>

                        <div class="col-xs-4 mb-3 mb-md-0">
                            <h4 class="mb-2" style="border-bottom: 1px solid #dddddd;padding-bottom: 10px;">Customer Info:</h4>
                            <div><strong>{{ $customer->customer_name }}</strong></div>
                            <div>{{ $customer->address }}</div>
                            <div>{{ __('Email') }}: {{ $customer->customer_email }}</div>
                            <div>{{ __('Phone Number') }}: {{ $customer->customer_phone }}</div>
                        </div>

                        <div class="col-xs-4 mb-3 mb-md-0">
                            <h4 class="mb-2" style="border-bottom: 1px solid #dddddd;padding-bottom: 10px;">Invoice Info:</h4>
                            <div>{{ __('Invoice') }}: <strong>INV/{{ $quotation->reference }}</strong></div>
                            <div>{{ __('Date') }}: {{ \Carbon\Carbon::parse($quotation->date)->format('d M, Y') }}</div>
                            <div>
                                {{ __('Status') }}: <strong>{{ $quotation->status }}</strong>
                            </div>
                            <div>
                                {{ __('Payment Status') }}: <strong>{{ $quotation->payment_status }}</strong>
                            </div>
                        </div>

                    </div>

                    <div class="table-responsive-sm" style="margin-top: 30px;">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="align-middle">{{ __('Product') }}</th>
                                <th class="align-middle">{{ __('Net Unit Price') }}</th>
                                <th class="align-middle">{{ __('Quantity') }}</th>
                                <th class="align-middle">{{ __('Discount') }}</th>
                                <th class="align-middle">{{ __('Tax') }}</th>
                                <th class="align-middle">{{ __('Sub Total') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($quotation->quotationDetails as $item)
                                <tr>
                                    <td class="align-middle">
                                        {{ $item->product_name }} <br>
                                        <span class="badge badge-success">
                                                {{ $item->product_code }}
                                            </span>
                                    </td>

                                    <td class="align-middle">{{ format_currency($item->unit_price) }}</td>

                                    <td class="align-middle">
                                        {{ $item->quantity }}
                                    </td>

                                    <td class="align-middle">
                                        {{ format_currency($item->product_discount_amount) }}
                                    </td>

                                    <td class="align-middle">
                                        {{ format_currency($item->product_tax_amount) }}
                                    </td>

                                    <td class="align-middle">
                                        {{ format_currency($item->sub_total) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-xs-offset-8">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td class="left"><strong>{{ __('Discount') }} ({{ $quotation->discount_percentage }}%)</strong></td>
                                    <td class="right">{{ format_currency($quotation->discount_amount) }}</td>
                                </tr>
                                <tr>
                                    <td class="left"><strong>{{ __('Tax') }} ({{ $quotation->tax_percentage }}%)</strong></td>
                                    <td class="right">{{ format_currency($quotation->tax_amount) }}</td>
                                </tr>
                                <tr>
                                    <td class="left"><strong>{{ __('Shipping') }}</strong></td>
                                    <td class="right">{{ format_currency($quotation->shipping_amount) }}</td>
                                </tr>
                                <tr>
                                    <td class="left"><strong>{{ __('Grand Total') }}</strong></td>
                                    <td class="right"><strong>{{ format_currency($quotation->total_amount) }}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 25px;">
                        <div class="col-xs-12">
                            <p style="font-style: italic;text-align: center">{{ settings()->company_name }} &copy; {{ date('Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
