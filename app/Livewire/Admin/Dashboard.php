<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'productCount' => Product::count(),
            'categoryCount' => Category::count(),
            'userCount' => User::count(),
            'featuredCount' => Product::where('is_featured', true)->count(),
        ])->layout('layouts.admin', [
            'title' => 'Dashboard',
        ]);
    }
}
