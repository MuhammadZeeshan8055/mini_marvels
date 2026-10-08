<div class="product-page" x-data="{ quantity: 1, tab: 'description' }">
    <section class="shop-banner" aria-labelledby="shop-title">
        <span class="shop-banner-kid shop-banner-kid-left" aria-hidden="true">&#129490;</span>
        <span class="shop-banner-bee shop-banner-bee-left" aria-hidden="true">&#128029;</span>
        <div class="shop-banner-copy">
            <h1 id="shop-title">Shop</h1>
            <nav aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>&rsaquo;</span>
                <span>{{ $product['category'] }}</span>
                <span>&rsaquo;</span>
                <span>{{ $product['name'] }}</span>
            </nav>
        </div>
        <span class="shop-banner-bee shop-banner-bee-right" aria-hidden="true">&#128029;</span>
        <span class="shop-banner-kid shop-banner-kid-right" aria-hidden="true">&#129490;</span>
    </section>

    <section class="product-detail-section">
        <div class="container product-detail-grid">
            @php($galleryImages = [$product['image'], ...array_column(array_slice($related, 0, 3), 'image')])
            <div class="product-gallery">
                <div class="swiper product-thumb-swiper" aria-label="Product image thumbnails">
                    <div class="swiper-wrapper">
                        @foreach ($galleryImages as $image)
                            <div class="swiper-slide" role="button" tabindex="0">
                                <img src="{{ $image }}" alt="" width="120" height="120" loading="lazy" draggable="false">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="swiper product-main-swiper" aria-label="Product gallery">
                    <div class="swiper-wrapper">
                        @foreach ($galleryImages as $index => $image)
                            <div class="swiper-slide">
                                <img src="{{ $image }}" alt="{{ $index === 0 ? $product['name'] : $product['name'].' alternate view' }}" width="720" height="720" draggable="false">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="product-summary">
                <h2>{{ $product['name'] }}</h2>
                <div class="product-detail-stars" aria-label="5 out of 5 stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                <div class="product-detail-price">${{ number_format($product['price'], 2) }}</div>
                <hr>
                <p>A playful, thoughtfully selected toy made for busy little hands and big imaginations. Durable, colorful, and ready for everyday adventures.</p>

                <div class="deal-countdown">
                    <strong>Hurry up! Deal Ends in:</strong>
                    <span>11d : 10h : 31m : 33s</span>
                </div>

                <div class="product-actions">
                    <div class="quantity-picker" aria-label="Quantity">
                        <button type="button" @click="quantity = Math.max(1, quantity - 1)" aria-label="Decrease quantity">&minus;</button>
                        <span x-text="quantity">1</span>
                        <button type="button" @click="quantity++" aria-label="Increase quantity">+</button>
                    </div>
                    <button type="button" class="product-add-button">Add To Cart</button>
                    <button type="button" class="product-wishlist" aria-label="Add to wishlist">&#9825;</button>
                </div>

                <ul class="product-perks">
                    <li>&#9678; Free worldwide shipping on orders over $200</li>
                    <li>&#128666; Delivers in 2–5 working days</li>
                    <li>&#8644; Shipping &amp; Return</li>
                </ul>

                <div class="product-payment-row" aria-label="Accepted payment methods">
                    <span>VISA</span><span>Mastercard</span><span>PayPal</span><span>Skrill</span><span>G Pay</span>
                </div>
                <dl class="product-meta">
                    <div><dt>SKU:</dt><dd>MM-{{ sprintf('%04d', crc32($product['name']) % 10000) }}</dd></div>
                    <div><dt>Category:</dt><dd>{{ $product['category'] }}</dd></div>
                </dl>
            </div>
        </div>
    </section>

    <section class="product-description-section">
        <div class="container">
            <div class="product-tabs" role="tablist" aria-label="Product information">
                <button type="button" :class="{ 'is-active': tab === 'description' }" @click="tab = 'description'">Description</button>
                <button type="button" :class="{ 'is-active': tab === 'additional' }" @click="tab = 'additional'">Additional Information</button>
            </div>

            <div class="product-tab-panel" x-show="tab === 'description'">
                <div class="product-description-copy">
                    <p>Designed to encourage imaginative, open-ended play, this cheerful toy is easy for children to enjoy and simple for parents to love. Its sturdy construction supports everyday playtime at home or on the go.</p>
                    <p>Bright details invite curiosity while the child-friendly design helps little ones build confidence, coordination, and creativity through play.</p>
                    <div class="product-checks">
                        <strong><span>&check;</span> Safe, child-friendly materials</strong>
                        <strong><span>&check;</span> Supports creative play</strong>
                        <strong><span>&check;</span> Durable everyday construction</strong>
                        <strong><span>&check;</span> A playful gift for kids</strong>
                    </div>
                </div>
                <img src="https://images.unsplash.com/photo-1588072432836-e10032774350?w=700&h=600&fit=crop" alt="Child enjoying educational toys" width="560" height="460" loading="lazy">
            </div>

            <div class="product-tab-panel product-additional" x-show="tab === 'additional'" x-cloak>
                <dl>
                    <div><dt>Recommended age</dt><dd>3 years and up</dd></div>
                    <div><dt>Materials</dt><dd>Child-safe mixed materials</dd></div>
                    <div><dt>Care</dt><dd>Wipe clean with a soft damp cloth</dd></div>
                    <div><dt>Packaging</dt><dd>Recyclable gift-ready box</dd></div>
                </dl>
            </div>
        </div>
    </section>

    <section class="product-feature-wrap">
        <div class="container">
            <div class="product-feature-banner">
                <div class="product-feature-image">
                    <img src="https://images.unsplash.com/photo-1598880940080-ff9a29891b85?w=700&h=700&fit=crop" alt="Children playing together" width="600" height="600" loading="lazy">
                </div>
                <div class="product-feature-copy">
                    <h2>Trendy moments for your kids at the best range.</h2>
                    <p>Discover colorful playtime favorites made to spark curiosity, creativity, and joyful moments together.</p>
                    <a href="{{ route('home') }}#products">Shop All Products</a>
                </div>
                <span class="feature-cloud feature-cloud-one" aria-hidden="true">&#9729;</span>
                <span class="feature-cloud feature-cloud-two" aria-hidden="true">&#9729;</span>
            </div>

            <div class="product-service-strip">
                @foreach ([
                    ['icon' => '&#128179;', 'title' => 'Secured Payments', 'text' => 'Safe checkout every time.'],
                    ['icon' => '&#8644;', 'title' => 'Easy Return Policy', 'text' => 'Hassle-free returns.'],
                    ['icon' => '&#128666;', 'title' => 'Free Shipping', 'text' => 'On qualifying orders.'],
                    ['icon' => '&#127911;', 'title' => 'Online Support', 'text' => 'We are here to help.'],
                ] as $service)
                    <div class="product-service-item">
                        <span aria-hidden="true">{!! $service['icon'] !!}</span>
                        <div><strong>{{ $service['title'] }}</strong><small>{{ $service['text'] }}</small></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section related-products-section">
        <div class="container">
            <h2>Related Products</h2>
            <div class="product-grid related-product-grid">
                @foreach ($related as $item)
                    <x-product-card :name="$item['name']" :category="$item['category']" :price="$item['price']" :image="$item['image']" />
                @endforeach
            </div>
        </div>
    </section>
</div>
