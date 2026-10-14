<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    public ?int $viewingId = null;

    public string $status = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function view(int $id): void
    {
        $order = Order::query()->findOrFail($id);
        $this->viewingId = $order->id;
        $this->status = $order->status;
    }

    public function closeView(): void
    {
        $this->viewingId = null;
        $this->status = '';
    }

    public function updateStatus(): void
    {
        $order = Order::query()->findOrFail($this->viewingId);

        $this->validate([
            'status' => ['required', 'in:'.implode(',', Order::STATUSES)],
        ]);

        $order->update(['status' => $this->status]);

        $this->dispatch('toast', message: 'Order status updated.', type: 'success');
    }

    public function render()
    {
        $orders = Order::query()
            ->withCount('items')
            ->when($this->search !== '', function ($query) {
                $term = '%'.$this->search.'%';
                $query->where(function ($q) use ($term) {
                    $q->where('order_number', 'like', $term)
                        ->orWhere('customer_name', 'like', $term)
                        ->orWhere('customer_email', 'like', $term)
                        ->orWhere('customer_phone', 'like', $term);
                });
            })
            ->when($this->statusFilter !== '', fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(15);

        $viewing = $this->viewingId
            ? Order::query()->with('items')->find($this->viewingId)
            : null;

        return view('livewire.admin.orders', [
            'orders' => $orders,
            'viewing' => $viewing,
            'statuses' => Order::STATUSES,
        ])->layout('layouts.admin', [
            'title' => 'Orders',
        ]);
    }
}
