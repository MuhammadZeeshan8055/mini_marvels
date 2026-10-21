<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\Wishlist;
use Livewire\Attributes\On;
use Livewire\Component;

class WishlistButton extends Component
{
    public int $productId;

    public string $variant = 'card';

    #[On('wishlist-updated')]
    public function refresh(): void
    {
        // Keep heart state in sync across cards.
    }

    public function toggle(): void
    {
        $product = Product::query()->active()->find($this->productId);

        if (! $product) {
            return;
        }

        Wishlist::toggle($product);
        $this->dispatch('wishlist-updated');
    }

    public function getActiveProperty(): bool
    {
        return Wishlist::has($this->productId);
    }

    public function render()
    {
        return view('livewire.wishlist-button');
    }
}
