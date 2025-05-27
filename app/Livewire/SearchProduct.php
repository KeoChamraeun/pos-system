<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Product\Entities\Product;
use Illuminate\Support\Facades\Auth;

class SearchProduct extends Component
{
    public $query;
    public $search_results;
    public $how_many;

    public function mount() {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }

    public function render() {
        return view('livewire.search-product');
    }

    public function updatedQuery() {
        $userId = Auth::id(); // Get logged-in user id

        $this->search_results = Product::where('user_id', $userId)
            ->where(function($query) {
                $query->where('product_name', 'like', '%' . $this->query . '%')
                      ->orWhere('product_code', 'like', '%' . $this->query . '%');
            })
            ->take($this->how_many)
            ->get();
    }

    public function loadMore() {
        $this->how_many += 5;
        $this->updatedQuery();
    }

    public function resetQuery() {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }

    public function selectProduct($product) {
        $this->dispatch('productSelected', $product);
    }
}
