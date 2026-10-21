<div class="cart-page">
    <section class="shop-banner cart-banner" aria-labelledby="wishlist-title">
        <div class="cart-banner-art cart-banner-art-left" aria-hidden="true">
            <span class="cart-kid">🧒</span><span class="cart-bee">🐝</span>
        </div>
        <div class="shop-banner-copy">
            <h1 id="wishlist-title">Wishlist</h1>
            <nav aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>›</span>
                <span aria-current="page">Wishlist</span>
            </nav>
        </div>
        <div class="cart-banner-art cart-banner-art-right" aria-hidden="true">
            <span class="cart-bee">🐝</span><span class="cart-kid">👧</span>
        </div>
    </section>

    <section class="cart-content" aria-label="Wishlist">
        <div class="cart-container">
            @if (count($this->items))
                <div class="cart-table-wrap">
                    <table class="cart-table wishlist-table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Stock</th>
                                <th scope="col"><span class="sr-only">Actions</span></th>
                                <th scope="col"><span class="sr-only">Remove</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->items as $item)
                                <tr wire:key="wishlist-item-{{ $item['id'] }}">
                                    <td data-label="Product">
                                        <div class="cart-product">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" width="74" height="74">
                                            <div class="cart-product-meta">
                                                <a href="{{ route('product.show', ['slug' => $item['slug']]) }}">{{ $item['name'] }}</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Price">Rs {{ number_format($item['price'], 0) }}</td>
                                    <td data-label="Stock">In stock</td>
                                    <td data-label="Actions">
                                        <button
                                            type="button"
                                            class="cart-pill wishlist-cart-btn"
                                            wire:click="addToCart({{ $item['id'] }})"
                                        >
                                            Add to cart
                                        </button>
                                    </td>
                                    <td>
                                        <button
                                            class="cart-remove"
                                            type="button"
                                            wire:click="removeItem({{ $item['id'] }})"
                                            aria-label="Remove {{ $item['name'] }}"
                                        >×</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-cart">
                    <span aria-hidden="true">♡</span>
                    <h2>Your wishlist is empty</h2>
                    <p>Tap the heart on any toy to save it here.</p>
                    <a href="{{ route('shop') }}" class="cart-pill">Continue Shopping</a>
                </div>
            @endif
        </div>
    </section>
</div>
