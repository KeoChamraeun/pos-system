<div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form wire:submit="generateReport">
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>{{ __('Start Date') }}<span class="text-danger">*</span></label>
                                    <input wire:model="start_date" type="date" class="form-control" name="start_date">
                                    @error('start_date')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>{{ __('End Date') }}<span class="text-danger">*</span></label>
                                    <input wire:model="end_date" type="date" class="form-control" name="end_date">
                                    @error('end_date')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>{{ __('Supplier') }}</label>
                                    <select wire:model="supplier_id" class="form-control" name="supplier_id">
                                        <option value="">{{ __('Select Supplier') }}</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{ __('Status') }}</label>
                                    <select wire:model="purchase_status" class="form-control" name="purchase_status">
                                        <option value="">{{ __('Select Status') }}</option>
                                        <option value="Pending">{{ __('Pending') }}</option>
                                        <option value="Ordered">{{ __('Ordered') }}</option>
                                        <option value="Completed">{{ __('Completed') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{ __('Payment Status') }}</label>
                                    <select wire:model="payment_status" class="form-control" name="payment_status">
                                        <option value="">{{ __('Select Payment Status') }}</option>
                                        <option value="Paid">{{ __('Paid') }}</option>
                                        <option value="Unpaid">{{ __('Unpaid') }}</option>
                                        <option value="Partial">{{ __('Partial') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <span wire:target="generateReport" wire:loading class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <i wire:target="generateReport" wire:loading.remove class="bi bi-shuffle"></i>
                                {{ __('Filter Report') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <table class="table table-bordered table-striped text-center mb-0">
                        <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">{{ __('Loading...') }}</span>
                            </div>
                        </div>
                        <thead>
                        <tr>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Reference') }}</th>
                            <th>{{ __('Supplier') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Total') }}</th>
                            <th>{{ __('Paid') }}</th>
                            <th>{{ __('Due') }}</th>
                            <th>{{ __('Payment Status') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($purchases as $purchase)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($purchase->date)->format('d M, Y') }}</td>
                                <td>{{ $purchase->reference }}</td>
                                <td>{{ $purchase->supplier_name }}</td>
                                <td>
                                    @if ($purchase->status == 'Pending')
                                        <span class="badge badge-info">
                                    {{ $purchase->status }}
                                </span>
                                    @elseif ($purchase->status == 'Ordered')
                                        <span class="badge badge-primary">
                                    {{ $purchase->status }}
                                </span>
                                    @else
                                        <span class="badge badge-success">
                                    {{ $purchase->status }}
                                </span>
                                    @endif
                                </td>
                                <td>{{ format_currency($purchase->total_amount) }}</td>
                                <td>{{ format_currency($purchase->paid_amount) }}</td>
                                <td>{{ format_currency($purchase->due_amount) }}</td>
                                <td>
                                    @if ($purchase->payment_status == 'Partial')
                                        <span class="badge badge-warning">
                                    {{ $purchase->payment_status }}
                                </span>
                                    @elseif ($purchase->payment_status == 'Paid')
                                        <span class="badge badge-success">
                                    {{ $purchase->payment_status }}
                                </span>
                                    @else
                                        <span class="badge badge-danger">
                                    {{ $purchase->payment_status }}
                                </span>
                                    @endif

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <span class="text-danger">{{ __('No Purchases Data Available!') }}</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div @class(['mt-3' => $purchases->hasPages()])>
                        {{ $purchases->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
