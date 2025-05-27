<!DOCTYPE html>
<html lang="kh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Sale Details') }}</title>

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
    <div class="container">
        <div class="header">
            <img src="{{ public_path('images/logo-dark.png') }}" alt="{{ __('Company Logo') }}">
            <h4>{{ __('Reference') }}: <strong>{{ $sale->reference }}</strong></h4>
        </div>

        <div class="info-grid">
            <div class="info-section">
                <h4>{{ __('Company Info') }}</h4>
                <div><strong>{{ settings()->company_name }}</strong></div>
                <div>{{ settings()->company_address }}</div>
                <div>{{ __('Email') }}: {{ settings()->company_email }}</div>
                <div>{{ __('Phone Number') }}: {{ settings()->company_phone }}</div>
            </div>
            <div class="info-section">
                <h4>{{ __('Customer Info') }}</h4>
                <div><strong>{{ $customer->customer_name }}</strong></div>
                <div>{{ $customer->address }}</div>
                <div>{{ __('Email') }}: {{ $customer->customer_email }}</div>
                <div>{{ __('Phone Number') }}: {{ $customer->customer_phone }}</div>
            </div>
            <div class="info-section">
                <h4>{{ __('Invoice Info') }}</h4>
                <div>{{ __('Invoice') }}: <strong>INV/{{ $sale->reference }}</strong></div>
                <div>{{ __('Date') }}: {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}</div>
                <div>{{ __('Status') }}: <strong>{{ $sale->status }}</strong></div>
                <div>{{ __('Payment Status') }}: <strong>{{ $sale->payment_status }}</strong></div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Product') }}</th>
                    <th>{{ __('Unit Price') }}</th>
                    <th>{{ __('Quantity') }}</th>
                    <th>{{ __('Discount') }}</th>
                    <th>{{ __('Tax') }}</th>
                    <th>{{ __('Sub Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->saleDetails as $item)
                    <tr>
                        <td>
                            {{ $item->product_name }}<br>
                            <span class="badge">{{ $item->product_code }}</span>
                        </td>
                        <td>{{ format_currency($item->unit_price) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ format_currency($item->product_discount_amount) }}</td>
                        <td>{{ format_currency($item->product_tax_amount) }}</td>
                        <td>{{ format_currency($item->sub_total) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="summary-table">
            <tbody>
                <tr>
                    <td><strong>{{ __('Discount') }} ({{ $sale->discount_percentage }}%)</strong></td>
                    <td>{{ format_currency($sale->discount_amount) }}</td>
                </tr>
                <tr>
                    <td><strong>{{ __('Tax') }} ({{ $sale->tax_percentage }}%)</strong></td>
                    <td>{{ format_currency($sale->tax_amount) }}</td>
                </tr>
                <tr>
                    <td><strong>{{ __('Shipping') }}</strong></td>
                    <td>{{ format_currency($sale->shipping_amount) }}</td>
                </tr>
                <tr>
                    <td><strong>{{ __('Grand Total') }}</strong></td>
                    <td><strong>{{ format_currency($sale->total_amount) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            {{ settings()->company_name }} © {{ date('Y') }}.
        </div>
    </div>
</body>

</html>
