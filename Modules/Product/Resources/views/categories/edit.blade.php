@extends('layouts.app')

@section('title', 'Edit Product Category')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('product-categories.index') }}">{{ __('Categories') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Edit') }}</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-7">
                @include('utils.alerts')
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('product-categories.update', $category->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-group">
                                <label class="font-weight-bold" for="category_code">{{ __('Category Code') }}<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="category_code" required
                                    value="{{ $category->category_code }}">
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold" for="category_name">{{ __('Category Name') }}<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="category_name" required
                                    value="{{ $category->category_name }}">
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold" for="product_image">{{ __('Category Image') }}</label>
                                <input class="form-control-file" type="file" name="product_image">
                                @if($category->product_image)
                                    <img src="{{ asset('storage/' . $category->product_image) }}" alt="Category Image"
                                        class="img-thumbnail mt-2" width="100">
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ __('Update') }} <i
                                        class="bi bi-check"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
