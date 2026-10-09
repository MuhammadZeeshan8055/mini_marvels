<div class="cart-page checkout-page">
    <section class="shop-banner cart-banner" aria-labelledby="checkout-title">
        <div class="cart-banner-art cart-banner-art-left" aria-hidden="true">
            <span class="cart-kid">🧒</span><span class="cart-bee">🐝</span>
        </div>
        <div class="shop-banner-copy">
            <h1 id="checkout-title">Checkout</h1>
            <nav aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>›</span>
                <a href="{{ route('cart') }}">Cart</a>
                <span>›</span>
                <span aria-current="page">Checkout</span>
            </nav>
        </div>
        <div class="cart-banner-art cart-banner-art-right" aria-hidden="true">
            <span class="cart-bee">🐝</span><span class="cart-kid">👧</span>
        </div>
    </section>

    <section class="cart-content checkout-content" aria-label="Checkout details">
        <div class="cart-container">
            @if ($orderPlaced)
                <div class="checkout-success" role="status">
                    <span aria-hidden="true">✓</span>
                    <p class="checkout-kicker">Thank you, {{ $name }}!</p>
                    <h2>Your order has been placed.</h2>
                    <p>We’ll send the order details to <strong>{{ $email }}</strong>.</p>
                    <div class="order-number">Order number <strong>{{ $orderNumber }}</strong></div>
                    <a href="{{ route('home') }}#products" class="cart-pill">Continue Shopping</a>
                </div>
            @else
                <div class="checkout-heading">
                    <div>
                        <span>Almost there!</span>
                        <h2>Delivery details</h2>
                        <p>Please enter the details below so we can deliver your little wonders safely.</p>
                    </div>
                </div>

                <form class="checkout-layout" wire:submit="placeOrder" novalidate>
                    <div class="cart-panel checkout-form-panel">
                        <div class="checkout-field-grid">
                            <div class="checkout-field">
                                <label for="checkout-name">Full name <span>*</span></label>
                                <input id="checkout-name" type="text" wire:model.blur="name" autocomplete="name" placeholder="Enter your full name">
                                @error('name') <small>{{ $message }}</small> @enderror
                            </div>

                            <div class="checkout-field">
                                <label for="checkout-phone">Phone number <span>*</span></label>
                                <input id="checkout-phone" type="tel" wire:model.blur="phone" autocomplete="tel" inputmode="tel" placeholder="+92 300 1234567">
                                @error('phone') <small>{{ $message }}</small> @enderror
                            </div>

                            <div class="checkout-field checkout-field-wide">
                                <label for="checkout-email">Email address <span>*</span></label>
                                <input id="checkout-email" type="email" wire:model.blur="email" autocomplete="email" placeholder="you@example.com">
                                <em>We’ll use this only for your order confirmation.</em>
                                @error('email') <small>{{ $message }}</small> @enderror
                            </div>

                            <div class="checkout-field checkout-field-wide">
                                <label for="checkout-address">Complete address <span>*</span></label>
                                <textarea id="checkout-address" wire:model.blur="address" autocomplete="street-address" rows="5" placeholder="House or apartment, street, area, city, province and postal code"></textarea>
                                @error('address') <small>{{ $message }}</small> @enderror
                            </div>

                            <div class="checkout-field checkout-field-wide">
                                <label for="checkout-note">Order note <b>(optional)</b></label>
                                <textarea id="checkout-note" wire:model.blur="note" rows="4" placeholder="Delivery instructions, gift message, or anything else we should know"></textarea>
                                @error('note') <small>{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    <aside class="cart-panel checkout-summary" aria-labelledby="order-summary-title">
                        <h2 id="order-summary-title">Your order</h2>
                        <div class="checkout-summary-head"><span>Product</span><span>Subtotal</span></div>
                        <ul>
                            @foreach ($items as $item)
                                <li>
                                    <div class="checkout-product">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" width="52" height="52">
                                        <span>{{ $item['name'] }} <b>× {{ $item['quantity'] }}</b></span>
                                    </div>
                                    <strong>${{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
                                </li>
                            @endforeach
                        </ul>
                        <dl>
                            <div><dt>Subtotal</dt><dd>${{ number_format($this->total, 2) }}</dd></div>
                            <div><dt>Shipping</dt><dd>Free Shipping</dd></div>
                            <div class="checkout-total"><dt>Total</dt><dd>${{ number_format($this->total, 2) }}</dd></div>
                        </dl>
                        <div class="checkout-payment">
                            <span class="payment-dot" aria-hidden="true"></span>
                            <div><strong>Cash on delivery</strong><small>Pay when your order arrives.</small></div>
                        </div>
                        <label class="checkout-terms">
                            <input type="checkbox" wire:model="terms">
                            <span>I agree to the terms and privacy policy.</span>
                        </label>
                        @error('terms') <small class="checkout-terms-error">{{ $message }}</small> @enderror
                        <button type="submit" class="cart-pill place-order-button" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="placeOrder">Place Order</span>
                            <span wire:loading wire:target="placeOrder">Placing Order…</span>
                        </button>
                        <p class="checkout-security">🔒 Your personal information is securely protected.</p>
                    </aside>
                </form>
            @endif
        </div>
    </section>
</div>
