<div class="cart-page">
    <section class="shop-banner cart-banner" aria-labelledby="cart-title">
        <div class="cart-banner-art cart-banner-art-left" aria-hidden="true">
            <span class="cart-kid">🧒</span><span class="cart-bee">🐝</span>
        </div>
        <div class="shop-banner-copy">
            <h1 id="cart-title">Cart</h1>
            <nav aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>›</span>
                <span aria-current="page">Cart</span>
            </nav>
        </div>
        <div class="cart-banner-art cart-banner-art-right" aria-hidden="true">
            <span class="cart-bee">🐝</span><span class="cart-kid">👧</span>
        </div>
    </section>

    <section class="cart-content" aria-label="Shopping cart">
        <div class="cart-container">
            @if (count($this->items))
                <div class="cart-table-wrap">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col"><span class="sr-only">Remove</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->items as $item)
                                <tr wire:key="cart-item-{{ $item['key'] }}">
                                    <td data-label="Product">
                                        <div class="cart-product">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" width="74" height="74">
                                            <div class="cart-product-meta">
                                                <a href="{{ route('product.show', ['slug' => $item['slug'] ?? \Illuminate\Support\Str::slug($item['name'])]) }}">{{ $item['name'] }}</a>
                                                @if (! empty($item['color']))
                                                    <span class="cart-item-color">Color: {{ $item['color'] }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Price">Rs {{ number_format($item['price'], 0) }}</td>
                                    <td data-label="Quantity">
                                        <div class="cart-quantity" aria-label="Quantity for {{ $item['name'] }}">
                                            <button type="button" wire:click="changeQuantity(@js($item['key']), -1)" aria-label="Decrease quantity">−</button>
                                            <span aria-live="polite">{{ $item['quantity'] }}</span>
                                            <button type="button" wire:click="changeQuantity(@js($item['key']), 1)" aria-label="Increase quantity">+</button>
                                        </div>
                                    </td>
                                    <td data-label="Subtotal">Rs {{ number_format($item['price'] * $item['quantity'], 0) }}</td>
                                    <td>
                                        <button class="cart-remove" type="button" wire:click="removeItem(@js($item['key']))" aria-label="Remove {{ $item['name'] }}">×</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="cart-update-row">
                    <span wire:loading wire:target="changeQuantity, removeItem">Updating cart…</span>
                    <button type="button" class="cart-pill cart-update-button">Update Cart</button>
                </div>
            @else
                <div class="empty-cart">
                    <span aria-hidden="true">🛒</span>
                    <h2>Your cart is empty</h2>
                    <p>There are lots of little wonders waiting to be discovered.</p>
                    <a href="{{ route('home') }}#products" class="cart-pill">Continue Shopping</a>
                </div>
            @endif

            <form id="coupon" class="cart-panel coupon-panel" wire:submit="applyCoupon">
                <label for="coupon-code">Coupon:</label>
                <div class="coupon-fields">
                    <input id="coupon-code" type="text" wire:model="coupon" placeholder="Coupon code" autocomplete="off">
                    <button type="submit" class="cart-pill">Apply Coupon</button>
                </div>
                @if ($couponMessage)
                    <p class="coupon-message {{ $couponApplied ? 'is-success' : '' }}" aria-live="polite">{{ $couponMessage }}</p>
                @endif
            </form>

            <section class="cart-panel cart-totals" aria-labelledby="cart-totals-title">
                <h2 id="cart-totals-title">Cart totals</h2>
                <dl>
                    <div><dt>Subtotal</dt><dd>Rs {{ number_format($this->subtotal, 0) }}</dd></div>
                    @if ($couponApplied)
                        <div><dt>Discount</dt><dd>−Rs {{ number_format($this->discount, 0) }}</dd></div>
                    @endif
                    <div class="shipping-row">
                        <dt>Shipment</dt>
                        <dd>
                            <strong>Free Shipping</strong>
                            <span>Shipping To</span>
                            <b>Pakistan.</b>
                            <button type="button" class="cart-pill change-address" wire:click="$toggle('showAddress')">Change Address</button>
                            @if ($showAddress)
                                <span class="address-note">Delivery location can be updated during checkout.</span>
                            @endif
                        </dd>
                    </div>
                    <div class="total-row"><dt>Total</dt><dd>Rs {{ number_format($this->total, 0) }}</dd></div>
                </dl>
                @if (count($this->items))
                    <a href="{{ route('checkout') }}" class="cart-pill checkout-button">Proceed To Checkout</a>
                @endif
            </section>
        </div>
    </section>
</div>
