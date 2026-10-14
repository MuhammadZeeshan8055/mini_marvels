<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $recentOrders = Order::query()
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'productCount' => Product::count(),
            'categoryCount' => Category::count(),
            'userCount' => User::count(),
            'orderCount' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'recentOrders' => $recentOrders,
        ])->layout('layouts.admin', [
            'title' => 'Dashboard',
        ]);
    }
}
