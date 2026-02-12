<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.admin-dashboard', [
            'productsCount' => Product::count(),
            'ordersCount' => Order::count(),
            'pendingOrders' => Order::where('status', Order::STATUS_PENDING)->count(),
            'confirmedOrders' => Order::where('status', Order::STATUS_CONFIRMED)->count(),
            'deliveredOrders' => Order::where('status', Order::STATUS_DELIVERED)->count(),
            'recentOrders' => Order::with('product')->latest()->take(5)->get(),
        ])->layout('components.layouts.admin');
    }
}
