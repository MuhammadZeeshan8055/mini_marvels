<?php

namespace App\Livewire;

use App\Services\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class HeaderCart extends Component
{
    public bool $open = false;

    #[On('cart-updated')]
    public function refreshCart(): void
    {
        // Re-render from session cart.
    }

    public function openCart(): void
    {
        $this->open = true;
    }

    public function closeCart(): void
    {
        $this->open = false;
    }

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    public function removeItem(string $key): void
    {
        Cart::remove($key);
        $this->dispatch('cart-updated');
    }

    public function getItemsProperty(): array
    {
        return Cart::items();
    }

    public function getCountProperty(): int
    {
        return Cart::count();
    }

    public function getSubtotalProperty(): float
    {
        return Cart::subtotal();
    }

    public function render()
    {
        return view('livewire.header-cart');
    }
}
