@extends('layouts.app')

@section('title', 'Update Supplier')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">{{ __('Suppliers') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Edit') }}</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col-lg-12">
                    @include('utils.alerts')
                    <div class="form-group">
                        <button class="btn btn-primary">{{ __('Update Supplier') }}<i class="bi bi-check"></i></button>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="supplier_name">{{ __('Supplier Name') }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="supplier_name" required value="{{ $supplier->supplier_name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="supplier_email">{{ __('Email') }}<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="supplier_email" required value="{{ $supplier->supplier_email }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="supplier_phone">{{ __('Phone Number') }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="supplier_phone" required value="{{ $supplier->supplier_phone }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="city">{{ __('City') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="city" required value="{{ $supplier->city }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="country">{{ __('Country') }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="country" required value="{{ $supplier->country }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="address">{{ __('Address') }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="address" required value="{{ $supplier->address }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

