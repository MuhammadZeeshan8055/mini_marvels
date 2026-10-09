<?php

namespace App\Livewire;

use Livewire\Component;

class CartPage extends Component
{
    public array $items = [
        [
            'id' => 1,
            'name' => 'Light Weight Baby Stroller',
            'price' => 24.85,
            'quantity' => 1,
            'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=180&h=180&fit=crop',
        ],
        [
            'id' => 2,
            'name' => 'Wooden Rocking Horse',
            'price' => 15.60,
            'quantity' => 1,
            'image' => 'https://images.unsplash.com/photo-1594787318286-3d835c1d207f?w=180&h=180&fit=crop',
        ],
    ];

    public string $coupon = '';

    public string $couponMessage = '';

    public bool $couponApplied = false;

    public bool $showAddress = false;

    public function changeQuantity(int $id, int $amount): void
    {
        foreach ($this->items as &$item) {
            if ($item['id'] === $id) {
                $item['quantity'] = max(1, $item['quantity'] + $amount);
                break;
            }
        }
    }

    public function removeItem(int $id): void
    {
        $this->items = array_values(array_filter(
            $this->items,
            fn (array $item) => $item['id'] !== $id
        ));
    }

    public function applyCoupon(): void
    {
        if (strtoupper(trim($this->coupon)) === 'CUTIE10') {
            $this->couponApplied = true;
            $this->couponMessage = 'Coupon applied — 10% off!';
            return;
        }

        $this->couponApplied = false;
        $this->couponMessage = 'Try CUTIE10 for 10% off.';
    }

    public function getSubtotalProperty(): float
    {
        return collect($this->items)->sum(
            fn (array $item) => $item['price'] * $item['quantity']
        );
    }

    public function getDiscountProperty(): float
    {
        return $this->couponApplied ? round($this->subtotal * 0.1, 2) : 0;
    }

    public function getTotalProperty(): float
    {
        return $this->subtotal - $this->discount;
    }

    public function render()
    {
        return view('livewire.cart-page')->layout('layouts.app', [
            'title' => 'Cart — Mini Marvels',
            'metaDescription' => 'Review your Mini Marvels shopping cart.',
        ]);
    }
}
