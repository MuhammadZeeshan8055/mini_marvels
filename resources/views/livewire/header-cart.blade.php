<div class="header-cart-wrap" @keydown.escape.window="$wire.closeCart()" @click.outside="$wire.closeCart()">
    <button
        type="button"
        class="icon-btn"
        wire:click="toggle"
        aria-expanded="{{ $open ? 'true' : 'false' }}"
        aria-controls="header-cart"
        aria-label="Open cart"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 8h12l-1 11H7L6 8z"/><path stroke-linecap="round" d="M9 8a3 3 0 0 1 6 0"/>
        </svg>
        @if ($this->count > 0)
            <span class="badge">{{ $this->count }}</span>
        @endif
    </button>

    <aside
        id="header-cart"
        class="header-cart {{ $open ? 'open' : '' }}"
        aria-label="Shopping cart"
    >
        @forelse ($this->items as $item)
            <div class="header-cart-item" wire:key="header-cart-{{ $item['key'] }}">
                <button
                    type="button"
                    class="header-cart-remove"
                    wire:click="removeItem(@js($item['key']))"
                    aria-label="Remove {{ $item['name'] }}"
                >&times;</button>
                <div class="header-cart-copy">
                    <strong>
                        <a href="{{ route('product.show', ['slug' => $item['slug'] ?? \Illuminate\Support\Str::slug($item['name'])]) }}">
                            {{ $item['name'] }}
                        </a>
                    </strong>
                    @if (! empty($item['color']))
                        <em class="header-cart-color">{{ $item['color'] }}</em>
                    @endif
                    <span>{{ $item['quantity'] }} &times; Rs {{ number_format($item['price'], 0) }}</span>
                </div>
                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}{{ ! empty($item['color']) ? ' — '.$item['color'] : '' }}" width="88" height="88" loading="lazy">
            </div>
        @empty
            <p class="header-cart-empty">Your cart is empty.</p>
        @endforelse

        @if (count($this->items))
            <div class="header-cart-total">
                <strong>Subtotal:</strong>
                <span>Rs {{ number_format($this->subtotal, 0) }}</span>
            </div>

            <a href="{{ route('cart') }}" class="header-cart-action" wire:click="closeCart">View Cart</a>
            <a href="{{ route('checkout') }}" class="header-cart-action" wire:click="closeCart">Checkout</a>
        @else
            <a href="{{ route('shop') }}" class="header-cart-action" wire:click="closeCart">Shop Now</a>
        @endif
    </aside>
</div>
