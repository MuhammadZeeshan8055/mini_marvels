<div>
{{-- Hero --}}
<section class="section" style="padding-top: 1.5rem;">
    <div class="container">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                @foreach ($slides as $index => $slide)
                    <div class="swiper-slide">
                        <div class="hero-slide" style="background: {{ $slide['bg'] }};">
                            <div class="hero-content">
                                <div class="hero-eyebrow">{{ $slide['eyebrow'] }}</div>
                                @if ($index === 0)
                                    <h1 class="hero-title">{{ $slide['title'] }}</h1>
                                @else
                                    <h2 class="hero-title">{{ $slide['title'] }}</h2>
                                @endif
                                <p class="hero-text">{{ $slide['text'] }}</p>
                                <a href="#products" class="btn btn-plum">Shop Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>

{{-- Categories --}}
<section id="categories" class="section" style="padding-top: 1rem;">
    <div class="container">
        <x-section-heading title="Shop By Category" subtitle="Browse playful picks for every little adventure." />
        <div class="cat-scroll">
            @foreach ($categories as $category)
                <a href="#products" class="cat-card">
                    <div class="cat-emoji">{{ $category['emoji'] }}</div>
                    <div class="cat-name">{{ $category['name'] }}</div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Shop by age --}}
<section class="section" style="background: #fff; padding-top: 2.5rem; padding-bottom: 2.5rem;">
    <div class="container">
        <x-section-heading
            title="Shop By Kids Age"
            subtitle="Find age-right toys that are fun, safe, and ready for playtime."
        />
        <div class="age-grid">
            @foreach ($ages as $age)
                <a href="#products" class="age-card" style="background: {{ $age['color'] }};">
                    {{ $age['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Products --}}
<section id="products" class="section">
    <div class="container">
        <x-section-heading
            title="Our Top Selling Products"
            subtitle="Cute deals on stuffed toys, wood toys, and everyday play favorites."
        />
        <div class="product-grid">
            @foreach ($products as $product)
                <x-product-card
                    :name="$product['name']"
                    :category="$product['category']"
                    :price="$product['price']"
                    :image="$product['image']"
                />
            @endforeach
        </div>
        <div class="text-center" style="margin-top: 2rem;">
            <a href="#products" class="btn btn-primary">View All Products</a>
        </div>
    </div>
</section>

{{-- Promo banners --}}
<section class="section" style="padding-top: 1rem;">
    <div class="container">
        <div class="promo-grid">
            @foreach ($promos as $promo)
                <div class="promo-card" style="background: {{ $promo['bg'] }}; color: {{ $promo['text'] }};">
                    <div class="subtitle">{{ $promo['subtitle'] }}</div>
                    <h3>{{ $promo['title'] }}</h3>
                    <div style="font-weight: 600;">{{ $promo['price'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Trust --}}
<section class="section" style="padding-top: 1rem;">
    <div class="container">
        <div class="trust-grid">
            @foreach ($trust as $item)
                <div class="trust-card">
                    <div class="emoji">{{ $item['emoji'] }}</div>
                    <h3>{{ $item['title'] }}</h3>
                    <p>{{ $item['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured --}}
<section class="section" style="background: #fff;">
    <div class="container">
        <x-section-heading
            title="Featured Toys"
            subtitle="Hand-picked favorites parents and kids both love."
        />
        <div class="product-grid">
            @foreach ($featured as $product)
                <x-product-card
                    :name="$product['name']"
                    :category="$product['category']"
                    :price="$product['price']"
                    :image="$product['image']"
                />
            @endforeach
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section id="testimonials" class="section">
    <div class="container">
        <x-section-heading
            title="Client Testimonials"
            subtitle="Happy families shopping Mini Marvels every day."
        />
        <div class="testimonial-grid">
            @foreach ($testimonials as $item)
                <div class="testimonial-card">
                    <p>“{{ $item['text'] }}”</p>
                    <strong>{{ $item['name'] }}</strong>
                    <span>{{ $item['role'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Newsletter --}}
<section id="newsletter" class="section" style="padding-top: 1rem;">
    <div class="container">
        <div class="newsletter">
            <h2 class="section-title" style="margin-bottom: 0.5rem;">Our Newsletter</h2>
            <p class="section-sub" style="margin-bottom: 0;">
                Stay up to date with the latest kids deals and new arrivals.
            </p>
            <form class="newsletter-form" onsubmit="event.preventDefault();">
                <input type="email" name="email" placeholder="Enter your email" aria-label="Email" required>
                <button type="submit" class="btn btn-plum">Submit</button>
            </form>
            <p style="margin-top: 0.75rem; font-size: 0.8rem; color: #6b6575;">
                Your email is safe with us. We don't spam.
            </p>
        </div>
    </div>
</section>
</div>
