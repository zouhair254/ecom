<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;

class AdminOrders extends Component
{
    public bool $showDetails = false;
    public ?Order $selectedOrder = null;

    public bool $confirmingDelete = false;
    public ?int $deletingOrderId = null;

    public function viewOrder(int $id): void
    {
        $this->selectedOrder = Order::with('product')->findOrFail($id);
        $this->showDetails = true;
    }

    public function closeDetails(): void
    {
        $this->showDetails = false;
        $this->selectedOrder = null;
    }

    public function updateStatus(int $id, string $status): void
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $status]);
        $this->dispatch('toast', message: 'تم تحديث حالة الطلب بنجاح');

        if ($this->selectedOrder && $this->selectedOrder->id === $id) {
            $this->selectedOrder = $order->fresh('product');
        }
    }

    public function confirmDelete(int $id): void
    {
        $this->confirmingDelete = true;
        $this->deletingOrderId = $id;
    }

    public function deleteOrder(): void
    {
        if ($this->deletingOrderId) {
            Order::findOrFail($this->deletingOrderId)->delete();
            $this->dispatch('toast', message: 'تم حذف الطلب بنجاح');
        }
        $this->confirmingDelete = false;
        $this->deletingOrderId = null;
        $this->closeDetails();
    }

    public function cancelDelete(): void
    {
        $this->confirmingDelete = false;
        $this->deletingOrderId = null;
    }

    public function render()
    {
        return view('livewire.admin.admin-orders', [
            'orders' => Order::with('product')->latest()->get(),
        ])->layout('components.layouts.admin');
    }
}
