<div>
{{-- Hero (Cutie-style purple) --}}
<section class="hero-cutie" aria-label="Featured">
    {{-- Shared clip-path for blob image shape --}}
    <svg class="hero-clip-defs" width="0" height="0" aria-hidden="true">
        <defs>
            <clipPath id="heroBlobClip" clipPathUnits="objectBoundingBox">
                {{-- Wide four-sided wave: pinched top, tucked sides, and a dipped bottom --}}
                <path d="
                    M 0.27 0.06
                    C 0.38 0.02, 0.43 0.14, 0.49 0.20
                    C 0.56 0.28, 0.62 0.15, 0.70 0.07
                    C 0.77 0.00, 0.87 0.04, 0.91 0.15
                    C 0.97 0.29, 0.98 0.46, 0.96 0.61
                    C 0.94 0.79, 0.88 0.94, 0.76 0.94
                    C 0.66 0.94, 0.59 0.84, 0.51 0.82
                    C 0.43 0.80, 0.35 0.95, 0.22 0.96
                    C 0.08 0.97, 0.00 0.87, 0.02 0.73
                    C 0.03 0.63, 0.18 0.62, 0.20 0.52
                    C 0.23 0.39, 0.13 0.10, 0.27 0.06
                    Z"/>
            </clipPath>
        </defs>
    </svg>

    {{-- Background doodles --}}
    <div class="hero-doodles" aria-hidden="true">
        <svg class="doodle-corner-tl" viewBox="0 0 220 160" fill="none">
            <path d="M0 0 H180 C120 40 90 90 0 130 Z" fill="#E8C56A"/>
        </svg>
        <svg class="doodle-scribble" viewBox="0 0 80 40" fill="none">
            <path d="M5 28 C18 5 28 35 42 12 C52 -2 62 28 75 18" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
        </svg>
        <svg class="doodle-star" viewBox="0 0 24 24" fill="#F5D76E">
            <path d="M12 2l2.4 7.2H22l-6 4.4 2.3 7.2L12 16.8 5.7 20.8 8 13.6 2 9.2h7.6L12 2z"/>
        </svg>
        <svg class="doodle-cloud" viewBox="0 0 64 40" fill="#9FD6F5">
            <ellipse cx="28" cy="24" rx="18" ry="12"/><ellipse cx="42" cy="22" rx="14" ry="10"/><ellipse cx="20" cy="20" rx="12" ry="9"/>
        </svg>
        <svg class="doodle-sun" viewBox="0 0 80 80" fill="none">
            <circle cx="40" cy="40" r="14" stroke="#F5D76E" stroke-width="3"/>
            <path d="M40 8v10M40 62v10M8 40h10M62 40h10M16 16l7 7M57 57l7 7M16 64l7-7M57 23l7-7" stroke="#F5D76E" stroke-width="3" stroke-linecap="round"/>
            <path d="M40 28c6 0 10 5 8 10" stroke="#F5D76E" stroke-width="2.5" stroke-linecap="round"/>
        </svg>
        <svg class="doodle-rainbow" viewBox="0 0 110 65" fill="none">
            <path d="M10 55 A40 40 0 0 1 100 55" stroke="#F7A8C5" stroke-width="6" stroke-linecap="round"/>
            <path d="M18 55 A32 32 0 0 1 92 55" stroke="#F5D76E" stroke-width="6" stroke-linecap="round"/>
            <path d="M26 55 A24 24 0 0 1 84 55" stroke="#A8E6CF" stroke-width="6" stroke-linecap="round"/>
            <ellipse cx="14" cy="55" rx="10" ry="7" fill="#fff"/><ellipse cx="96" cy="55" rx="10" ry="7" fill="#fff"/>
        </svg>
        <svg class="doodle-dashes" viewBox="0 0 40 50" fill="#9FD6F5">
            <rect x="4" y="4" width="14" height="3" rx="1"/><rect x="4" y="12" width="14" height="3" rx="1"/>
            <rect x="4" y="20" width="14" height="3" rx="1"/><rect x="4" y="28" width="14" height="3" rx="1"/>
            <rect x="4" y="36" width="14" height="3" rx="1"/>
        </svg>
        <svg class="doodle-stars-trail" viewBox="0 0 120 55" fill="none">
            <path d="M5 40 C30 10 55 45 80 18" stroke="#fff" stroke-width="2" stroke-dasharray="3 5" stroke-linecap="round"/>
            <path d="M78 10l2 6h6l-5 4 2 6-5-3.5-5 3.5 2-6-5-4h6z" fill="#9FD6F5"/>
            <path d="M95 22l1.5 4.5h4.5l-3.5 2.8 1.4 4.5-3.9-2.6-3.9 2.6 1.4-4.5-3.5-2.8h4.5z" fill="#9FD6F5"/>
            <path d="M108 8l1.2 3.6h3.6l-2.8 2.2 1.1 3.6-3.1-2.1-3.1 2.1 1.1-3.6-2.8-2.2h3.6z" fill="#9FD6F5"/>
        </svg>
        <svg class="doodle-corner-br" viewBox="0 0 240 180" fill="none">
            <path d="M240 180 V40 C180 80 120 120 40 180 Z" fill="#E8C56A"/>
        </svg>
    </div>

    <aside class="hero-social" aria-label="Social">
        <a href="#">Facebook</a>
        <a href="#">Instagram</a>
        <a href="#">Twitter</a>
        <a href="#">LinkedIn</a>
    </aside>

    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            @foreach ($slides as $index => $slide)
                <div class="swiper-slide">
                    <div class="hero-cutie-inner">
                        <div class="hero-content">
                            <div class="hero-eyebrow {{ !empty($slide['eyebrow_box']) ? 'is-boxed' : '' }}">
                                {{ $slide['eyebrow'] }}
                            </div>

                            @if ($index === 0)
                                <h1 class="hero-title {{ !empty($slide['title_dark']) ? 'is-dark' : '' }}">{{ $slide['title'] }}</h1>
                            @else
                                <h2 class="hero-title {{ !empty($slide['title_dark']) ? 'is-dark' : '' }}">{{ $slide['title'] }}</h2>
                            @endif

                            <p class="hero-text">{{ $slide['text'] }}</p>
                            <a href="#products" class="btn-shop">Shop Now</a>
                        </div>

                        <div class="hero-media">
                            <div class="hero-blob-wrap">
                                {{-- Accent strokes following the four-sided wave --}}
                                <svg class="hero-blob-strokes" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                                    {{-- top valley accent --}}
                                    <path class="stroke-arc" d="M39,4 C43,5 46,13 49,17 C55,23 60,12 66,4"/>
                                    {{-- top-right hump --}}
                                    <path class="stroke-arc" d="M80,1 C91,4 97,14 99,25"/>
                                    {{-- bottom-center dip --}}
                                    <path class="stroke-arc" d="M42,91 C49,84 55,84 62,91"/>
                                    {{-- bottom-left --}}
                                    <path class="stroke-arc" d="M21,100 C7,101 -2,92 0,77 C1,71 2,67 5,64"/>
                                </svg>
                                <span class="hero-blob-cloud" aria-hidden="true"></span>

                                <div class="hero-blob">
                                    <img
                                        src="{{ $slide['image'] }}"
                                        alt="{{ $slide['title'] }}"
                                        width="900"
                                        height="900"
                                        @if($index > 0) loading="lazy" @endif
                                    >
                                </div>
                            </div>
                            <div class="hero-nav-spacer" aria-hidden="true"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="hero-nav hero-nav-float">
        <button type="button" class="hero-nav-btn hero-prev" aria-label="Previous slide">
            <span class="circle">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
            </span>
            Previous
        </button>
        <button type="button" class="hero-nav-btn hero-next" aria-label="Next slide">
            <span class="circle">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
            </span>
            Next
        </button>
    </div>
</section>

{{-- Categories --}}
<section id="categories" class="category-showcase" aria-label="Shop by category">
    <nav class="category-menu" aria-label="Toy categories">
        <div class="category-menu-track">
            @foreach ($categories as $category)
                <a href="#products" class="category-menu-item">
                    <span class="category-menu-mark" aria-hidden="true">&#10022;</span>
                    <span>{{ $category['name'] }}</span>
                </a>
            @endforeach
        </div>
        <div class="category-menu-track" aria-hidden="true">
            @foreach ($categories as $category)
                <a href="#products" class="category-menu-item" tabindex="-1">
                    <span class="category-menu-mark" aria-hidden="true">&#10022;</span>
                    <span>{{ $category['name'] }}</span>
                </a>
            @endforeach
        </div>
    </nav>

    <div class="category-carousel-row">
        <button type="button" class="category-arrow category-prev" aria-label="Previous categories">
            <svg viewBox="0 0 32 20" aria-hidden="true"><path d="M30 10H4M11 3 4 10l7 7"/></svg>
        </button>

        <div class="swiper category-swiper">
            <div class="swiper-wrapper">
                @foreach ($categories as $index => $category)
                    <div class="swiper-slide">
                        <a href="#products" class="category-card">
                            <span class="category-image">
                                <img src="{{ $categoryImages[$index] }}" alt="" width="360" height="360" loading="lazy">
                            </span>
                            <span class="category-name">{{ $category['name'] }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="button" class="category-arrow category-next" aria-label="Next categories">
            <svg viewBox="0 0 32 20" aria-hidden="true"><path d="M2 10h26M21 3l7 7-7 7"/></svg>
        </button>
    </div>
</section>

{{-- Shop by age --}}
<section class="section age-shop" aria-labelledby="age-shop-title">
    <div class="container">
        <div class="age-heading">
            <img class="age-mascot age-monkey" src="{{ asset('images/age-monkey.svg') }}" alt="" aria-hidden="true">
            <div class="age-heading-content">
                <img class="age-rainbow" src="{{ asset('images/age-rainbow.svg') }}" alt="" aria-hidden="true">
                <h2 id="age-shop-title">Shop By Kids Age</h2>
                <p>Find the perfect collection for every stage of play.</p>
                <div class="age-grid">
                    @foreach ($ages as $age)
                        <a href="#products" class="age-card {{ $loop->first ? 'is-active' : '' }}">
                            {{ $age['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
            <img class="age-mascot age-leopard" src="{{ asset('images/age-leopard.svg') }}" alt="" aria-hidden="true">
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
            @foreach ($promos as $index => $promo)
                <article class="promo-card promo-card-{{ $index + 1 }}" style="--promo-bg: {{ $promo['bg'] }}; --promo-text: {{ $promo['text'] }};">
                    <div class="promo-copy">
                        <div class="subtitle">{{ $promo['subtitle'] }}</div>
                        <h3>{{ $promo['title'] }}</h3>
                        <strong>{{ $promo['price'] }}</strong>
                    </div>
                    <div class="promo-image-wrap">
                        <img src="{{ $promo['image'] }}" alt="" width="420" height="520" loading="lazy">
                    </div>
                    <span class="promo-decor promo-decor-sun" aria-hidden="true">&#9728;</span>
                    <span class="promo-decor promo-decor-cloud" aria-hidden="true">&#9729;</span>
                    <span class="promo-decor promo-decor-rainbow" aria-hidden="true">&#127752;</span>
                </article>
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
<section id="testimonials" class="section testimonial-section" aria-labelledby="testimonial-title">
    <div class="container testimonial-layout">
        <div class="testimonial-intro">
            <span class="testimonial-kicker">Top Reviews</span>
            <h2 id="testimonial-title">Client Testimonials</h2>
            <p>Hear from families and teachers who make Mini Marvels part of every playful day.</p>
            <div class="testimonial-pagination" aria-label="Choose testimonial"></div>
        </div>

        <div class="testimonial-stage">
            <img class="testimonial-mascot" src="{{ asset('images/testimonial-giraffe.svg') }}" alt="" aria-hidden="true">
            <div class="swiper testimonial-swiper">
                <div class="swiper-wrapper">
                    @foreach ($testimonials as $item)
                        <div class="swiper-slide">
                            <article class="testimonial-card">
                                <div class="testimonial-profile">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" width="120" height="120" loading="lazy">
                                    <strong>{{ $item['name'] }}</strong>
                                    <span>{{ $item['role'] }}</span>
                                </div>
                                <div class="testimonial-divider" aria-hidden="true"></div>
                                <div class="testimonial-review">
                                    <div class="testimonial-stars" aria-label="5 out of 5 stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                                    <p>{{ $item['text'] }}</p>
                                </div>
                                <span class="review-doodle review-car" aria-hidden="true">&#128663;</span>
                                <span class="review-doodle review-sun" aria-hidden="true">&#9728;</span>
                                <span class="review-doodle review-rainbow" aria-hidden="true">&#127752;</span>
                                <span class="review-doodle review-star" aria-hidden="true">&#11088;</span>
                                <span class="review-doodle review-cloud" aria-hidden="true">&#9729;</span>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
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
