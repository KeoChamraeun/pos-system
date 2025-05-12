<div>
    <div class="form-row">
        <div class="col-md-7">
            <div class="form-group">
                <label>{{ __('Product Category') }}</label>
                <select wire:model.live="category" class="form-control">
                    <option value="">{{ __('All Products') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>{{ __('Product Count') }}</label>
                <select wire:model.live="showCount" class="form-control">
                    <option value="9">{{ __('9 Products') }}</option>
                    <option value="15">{{ __('15 Products') }}</option>
                    <option value="21">{{ __('21 Products') }}</option>
                    <option value="30">{{ __('30 Products') }}</option>
                    <option value="">{{ __('All Products') }}</option>
                </select>
            </div>
        </div>
    </div>
</div>
