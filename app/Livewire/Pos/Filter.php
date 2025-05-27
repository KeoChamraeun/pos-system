<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Filter extends Component
{
    public $categories;
    public $category;
    public $showCount;
    public $userId;

    public function mount($categories) {
        $this->categories = $categories;

        if (Auth::check()) {
            $this->userId = Auth::id();
        } else {
            abort(403, 'Unauthorized');
        }
    }

    public function render() {
        return view('livewire.pos.filter');
    }

    public function updatedCategory() {
        $this->dispatch('selectedCategory', $this->category);
    }

    public function updatedShowCount() {
        $this->dispatch('showCount', $this->category);
    }
}
