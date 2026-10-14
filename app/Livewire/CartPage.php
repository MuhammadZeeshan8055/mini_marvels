<?php

namespace App\Livewire;

use App\Services\Cart;
use Livewire\Component;

class CartPage extends Component
{
    public string $coupon = '';

    public string $couponMessage = '';

    public bool $couponApplied = false;

    public bool $showAddress = false;

    public function mount(): void
    {
        $this->coupon = Cart::coupon() ?? '';
        $this->couponApplied = Cart::coupon() === 'CUTIE10';

        if ($this->couponApplied) {
            $this->couponMessage = 'Coupon applied — 10% off!';
        }
    }

    public function changeQuantity(string $key, int $amount): void
    {
        $item = collect(Cart::items())->firstWhere('key', $key);

        if (! $item) {
            return;
        }

        Cart::updateQuantity($key, max(1, $item['quantity'] + $amount));
        $this->dispatch('cart-updated');
    }

    public function removeItem(string $key): void
    {
        Cart::remove($key);
        $this->dispatch('cart-updated');
    }

    public function applyCoupon(): void
    {
        if (Cart::applyCoupon($this->coupon)) {
            $this->couponApplied = true;
            $this->couponMessage = 'Coupon applied — 10% off!';
            $this->coupon = 'CUTIE10';

            return;
        }

        $this->couponApplied = false;
        $this->couponMessage = 'Try CUTIE10 for 10% off.';
    }

    public function getItemsProperty(): array
    {
        return Cart::items();
    }

    public function getSubtotalProperty(): float
    {
        return Cart::subtotal();
    }

    public function getDiscountProperty(): float
    {
        return Cart::discount();
    }

    public function getTotalProperty(): float
    {
        return Cart::total();
    }

    public function render()
    {
        return view('livewire.cart-page')->layout('layouts.app', [
            'title' => 'Cart — Mini Marvels',
            'metaDescription' => 'Review your Mini Marvels shopping cart.',
        ]);
    }
}
