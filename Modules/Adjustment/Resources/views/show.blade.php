@extends('layouts.app')

@section('title', 'Adjustment Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('adjustments.index') }}">{{ __('Adjustments') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Details') }}</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5>{{ __('Date') }}: {{ $adjustment->date }}</h5>
                <h5>{{ __('Reference') }}: {{ $adjustment->reference }}</h5>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Product Name') }}</th>
                                <th>{{ __('Code') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th>{{ __('Type') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($adjustment->adjustedProducts as $adjustedProduct)
                                <tr>
                                    <td>{{ $adjustedProduct->product->product_name }}</td>
                                    <td>{{ $adjustedProduct->product->product_code }}</td>
                                    <td>{{ $adjustedProduct->quantity }}</td>
                                    <td>
                                        @if($adjustedProduct->type == 'add')
                                            (+) Addition
                                        @else
                                            (-) Subtraction
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
