<div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            {{-- Alert message --}}
            @if (session()->has('message'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>{{ session('message') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Customer select with add button --}}
            <div class="mb-4">
                <label for="customer_id" class="form-label">{{ __('Customer') }} <span
                        class="text-danger">*</span></label>
                <div class="input-group">
                    <a href="{{ route('customers.create') }}" class="btn btn-primary"
                        title="{{ __('Add New Customer') }}">
                        <i class="bi bi-person-plus"></i>
                    </a>
                    <select wire:model.live="customer_id" id="customer_id" class="form-select">
                        <option value="" selected>{{ __('Select Customer') }}</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Cart Items Table --}}
            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($cart_items->isNotEmpty())
                            @foreach($cart_items as $cart_item)
                                <tr>
                                    <td class="text-start">
                                        <div>{{ $cart_item->name }}</div>
                                        <span class="badge bg-success">{{ $cart_item->options->code }}</span>
                                        @include('livewire.includes.product-cart-modal')
                                    </td>
                                    <td>{{ format_currency($cart_item->price) }}</td>
                                    <td>
                                        @include('livewire.includes.product-cart-quantity')
                                    </td>
                                    <td>
                                        <a href="#" wire:click.prevent="removeItem('{{ $cart_item->rowId }}')"
                                            class="text-danger fs-4">
                                            <i class="bi bi-x-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center text-danger">{{ __('Please search & select products!') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Summary Table --}}
            <div class="table-responsive mb-4">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>{{ __('Order Tax') }} ({{ $global_tax }}%)</th>
                            <td>(+) {{ format_currency(Cart::instance($cart_instance)->tax()) }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Discount') }} ({{ $global_discount }}%)</th>
                            <td>(-) {{ format_currency(Cart::instance($cart_instance)->discount()) }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Shipping') }}</th>
                            <input type="hidden" value="{{ $shipping }}" name="shipping_amount">
                            <td>(+) {{ format_currency($shipping) }}</td>
                        </tr>
                        <tr class="table-primary">
                            <th>{{ __('Grand Total') }}</th>
                            @php
$total_with_shipping = Cart::instance($cart_instance)->total() + (float) $shipping
                            @endphp
                            <th>(=) {{ format_currency($total_with_shipping) }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Inputs for tax, discount, shipping --}}
            <div class="row mb-4 g-3">
                <div class="col-md-4">
                    <label for="tax_percentage" class="form-label">{{ __('Order Tax') }} (%)</label>
                    <input wire:model.blur="global_tax" type="number" min="0" max="100" id="tax_percentage"
                        class="form-control" value="{{ $global_tax }}" required>
                </div>
                <div class="col-md-4">
                    <label for="discount_percentage" class="form-label">{{ __('Discount') }} (%)</label>
                    <input wire:model.blur="global_discount" type="number" min="0" max="100" id="discount_percentage"
                        class="form-control" value="{{ $global_discount }}" required>
                </div>
                <div class="col-md-4">
                    <label for="shipping_amount" class="form-label">{{ __('Shipping') }}</label>
                    <input wire:model.blur="shipping" type="number" min="0" step="0.01" id="shipping_amount"
                        class="form-control" value="{{ $shipping ?? 0 }}" required>
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <button wire:click="resetCart" type="button" class="btn btn-danger btn-pill px-4">
                    <i class="bi bi-x"></i> {{ __('Reset') }}
                </button>
                <button wire:loading.attr="disabled" wire:click="proceed" type="button"
                    class="btn btn-primary btn-pill px-4" {{ $total_amount == 0 ? 'disabled' : '' }}>
                    <i class="bi bi-check"></i> {{ __('Proceed') }}
                </button>
            </div>

        </div>
    </div>

    {{-- Checkout Modal --}}
    @include('livewire.pos.includes.checkout-modal')
    <style>
<style>
        .btn-outline-secondary i {
            margin-right: 5px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .badge {
            font-size: 0.85rem;
        }
        .card {
            border: 0;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .text-danger {
            color: #dc3545;
        }
    </style>

    </style>
</div>
