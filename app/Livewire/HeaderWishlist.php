<?php

namespace App\Livewire;

use App\Services\Wishlist;
use Livewire\Attributes\On;
use Livewire\Component;

class HeaderWishlist extends Component
{
    #[On('wishlist-updated')]
    public function refreshWishlist(): void
    {
        // Re-render badge from session.
    }

    public function getCountProperty(): int
    {
        return Wishlist::count();
    }

    public function render()
    {
        return view('livewire.header-wishlist');
    }
}
