<button
    type="button"
    class="{{ $variant === 'product' ? 'product-wishlist' : 'shop-wishlist-btn' }} {{ $this->active ? 'is-active' : '' }}"
    wire:click.stop="toggle"
    aria-label="{{ $this->active ? 'Remove from wishlist' : 'Add to wishlist' }}"
    aria-pressed="{{ $this->active ? 'true' : 'false' }}"
>
    {!! $this->active ? '&#9829;' : '&#9825;' !!}
</button>
