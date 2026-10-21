<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\Cart;
use App\Services\Wishlist;
use Livewire\Component;

class WishlistPage extends Component
{
    public function removeItem(int $productId): void
    {
        Wishlist::remove($productId);
        $this->dispatch('wishlist-updated');
    }

    public function addToCart(int $productId): void
    {
        $product = Product::query()->active()->find($productId);

        if (! $product || $product->stock < 1) {
            return;
        }

        Cart::add($product, 1);
        $this->dispatch('cart-updated');
    }

    public function getItemsProperty(): array
    {
        return Wishlist::items();
    }

    public function render()
    {
        return view('livewire.wishlist-page')->layout('layouts.app', [
            'title' => 'Wishlist — Mini Marvels',
            'metaDescription' => 'Your Mini Marvels wishlist of favorite toys.',
        ]);
    }
}
