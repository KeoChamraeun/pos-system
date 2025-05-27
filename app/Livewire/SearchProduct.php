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

    public function selectProduct($productId) {
        $userId = Auth::id(); // Get logged-in user id

        $product = Product::where('id', $productId)
                          ->where('user_id', $userId)
                          ->first();

        if ($product) {
            $this->dispatch('productSelected', $product);
        } else {
            // Optionally dispatch an error or flash message
            session()->flash('error', 'Product not found or unauthorized.');
        }
    }

}
