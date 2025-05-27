<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Entities\Product;

class ProductList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'selectedCategory' => 'categoryChanged',
        'showCount'        => 'showCountChanged'
    ];

    public $categories;
    public $category_id;
    public $limit = 9;
    public $userId;

    public function mount($categories) {
        $this->categories = $categories;
        $this->category_id = '';

        if (Auth::check()) {
            $this->userId = Auth::id();
        } else {
            abort(403, 'Unauthorized');
        }
    }

    public function render() {
        return view('livewire.pos.product-list', [
            'products' => Product::when($this->category_id, function ($query) {
                    $query->where('category_id', $this->category_id);
                })
                ->where('user_id', $this->userId) // filter by logged-in user
                ->paginate($this->limit)
        ]);
    }


    public function categoryChanged($category_id) {
        $this->category_id = $category_id;
        $this->resetPage();
    }

    public function showCountChanged($value) {
        $this->limit = $value;
        $this->resetPage();
    }

    public function selectProduct($product) {
        $this->dispatch('productSelected', $product);
    }
}
