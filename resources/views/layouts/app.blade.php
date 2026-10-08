<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $metaDescription ?? 'Mini Marvels — kids toys, deals, and playful learning.' }}">

    <title>{{ $title ?? 'Mini Marvels' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        plum: '#5D3E9F',
                        cream: '#FFF9E5',
                        mmPink: '#F7A8C5',
                        mmYellow: '#F6E27A',
                    },
                    fontFamily: {
                        display: ['Fredoka', 'system-ui', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @livewireStyles
</head>
<body class="font-display">
    {{-- Top promo bar --}}
    <div class="promo-bar" aria-label="Store announcement">
        <div class="promo-track">
            @for ($i = 0; $i < 2; $i++)
                <span class="promo-item"><span class="icon">★</span> Free Shipping On Orders Upto $49</span>
                <span class="promo-item"><span class="icon">🎁</span> Free Shipping On Orders Upto $49</span>
                <span class="promo-item"><span class="icon">🚚</span> Free Shipping On Orders Upto $49</span>
                <span class="promo-item"><span class="icon">★</span> Free Shipping On Orders Upto $49</span>
            @endfor
        </div>
    </div>

    {{-- Main header --}}
    <header class="site-header" x-data="{ open: false, cartOpen: false }" @click.outside="open = false; cartOpen = false" @keydown.escape.window="open = false; cartOpen = false">
        <div class="header-inner">
            <div class="flex items-center gap-2">
                <button type="button" class="menu-toggle icon-btn" @click="open = !open" :aria-expanded="open" aria-controls="mobile-menu" aria-label="Toggle menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/>
                    </svg>
                </button>

                <nav class="nav-left" aria-label="Main">
                    <a href="{{ url('/') }}">Home</a>
                    <a href="#categories">Pages</a>
                    <a href="#products">Shop</a>
                    <a href="#testimonials">Blog</a>
                    <a href="#newsletter">Contact Us</a>
                </nav>
            </div>

            <a href="{{ url('/') }}" class="logo-link" aria-label="Mini Marvels home">
                <img src="{{ asset('images/logo.png') }}" alt="Mini Marvels" width="180" height="72">
            </a>

            <div class="header-icons">
                <button type="button" class="icon-btn" aria-label="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m20 20-3-3"/>
                    </svg>
                </button>

                <a href="#login" class="icon-btn" aria-label="Account">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"/><path stroke-linecap="round" d="M4 20c1.5-3.5 4.5-5 8-5s6.5 1.5 8 5"/>
                    </svg>
                </a>

                <button type="button" class="icon-btn" @click="cartOpen = !cartOpen" :aria-expanded="cartOpen" aria-controls="header-cart" aria-label="Open cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 8h12l-1 11H7L6 8z"/><path stroke-linecap="round" d="M9 8a3 3 0 0 1 6 0"/>
                    </svg>
                    <span class="badge">2</span>
                </button>

                <a href="#wishlist" class="icon-btn" aria-label="Wishlist">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20s-7-4.5-7-9.5A4 4 0 0 1 12 7a4 4 0 0 1 7 3.5C19 15.5 12 20 12 20z"/>
                    </svg>
                    <span class="badge">0</span>
                </a>
            </div>
        </div>

        <aside id="header-cart" class="header-cart" :class="{ 'open': cartOpen }" aria-label="Shopping cart">
            <div class="header-cart-item">
                <button type="button" class="header-cart-remove" aria-label="Remove Light Weight Baby Stroller">&times;</button>
                <div class="header-cart-copy">
                    <strong>Light Weight<br>Baby Stroller</strong>
                    <span>1 &times; $24.85</span>
                </div>
                <img src="https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=180&h=180&fit=crop" alt="Light Weight Baby Stroller" width="88" height="88" loading="lazy">
            </div>

            <div class="header-cart-item">
                <button type="button" class="header-cart-remove" aria-label="Remove Wooden Rocking Horse">&times;</button>
                <div class="header-cart-copy">
                    <strong>Wooden Rocking<br>Horse</strong>
                    <span>1 &times; $15.60</span>
                </div>
                <img src="https://images.unsplash.com/photo-1594787318286-3d835c1d207f?w=180&h=180&fit=crop" alt="Wooden Rocking Horse" width="88" height="88" loading="lazy">
            </div>

            <div class="header-cart-total">
                <strong>Subtotal:</strong>
                <span>$40.45</span>
            </div>

            <a href="{{ route('product.show', ['slug' => 'push-ride-on-car']) }}" class="header-cart-action">View Cart</a>
            <a href="#newsletter" class="header-cart-action" @click="cartOpen = false">Checkout</a>
        </aside>

        <nav id="mobile-menu" class="mobile-nav" :class="{ 'open': open }" aria-label="Mobile">
            <a href="{{ url('/') }}" @click="open = false">Home</a>
            <a href="#categories" @click="open = false">Pages</a>
            <a href="#products" @click="open = false">Shop</a>
            <a href="#testimonials" @click="open = false">Blog</a>
            <a href="#newsletter" @click="open = false">Contact Us</a>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="site-footer">
        {{-- Layered cloud waves --}}
        <div class="footer-waves" aria-hidden="true">
            <svg class="footer-cloudscape" viewBox="0 0 1440 190" preserveAspectRatio="none">
                <path d="M0 72 C30 28 92 24 124 72 C144 55 174 50 203 68 C222 13 286 -7 334 18 C367 35 384 62 386 92 C426 64 479 73 500 111 C531 74 586 71 620 103 C650 54 719 47 758 88 C787 38 858 28 902 73 C929 58 960 59 985 82 C1020 45 1082 39 1118 78 C1152 56 1205 62 1230 99 C1264 57 1328 51 1361 92 C1380 72 1412 65 1440 72 L1440 190 L0 190 Z" fill="#86C5D5"/>
                <path d="M0 92 C54 93 70 44 119 44 C166 44 180 83 181 107 C210 70 264 71 300 114 C330 89 374 93 401 126 C434 101 487 100 520 126 C536 81 587 56 630 77 C666 94 674 124 672 143 C705 110 755 111 785 141 C812 98 871 84 914 112 C937 127 948 144 952 158 C982 128 1031 127 1065 151 C1090 118 1144 113 1179 143 C1200 121 1232 119 1255 139 C1280 100 1337 98 1369 130 C1383 103 1410 91 1440 92 L1440 190 L0 190 Z" fill="#5B43A5"/>
            </svg>
        </div>

        <div class="footer-main">
            <div class="container">
                {{-- Instagram-style gallery --}}
                <div class="footer-gallery">
                    <h3 class="footer-gallery-title">{{ '@Mini Marvels' }}</h3>
                    <div class="footer-gallery-row">
                        @foreach ([
                            'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=300&h=300&fit=crop',
                            'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=300&h=300&fit=crop',
                            'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?w=300&h=300&fit=crop',
                            'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=300&h=300&fit=crop',
                            'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=300&h=300&fit=crop',
                            'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?w=300&h=300&fit=crop',
                        ] as $galleryImage)
                            <a href="#" class="footer-gallery-item">
                                <img src="{{ $galleryImage }}" alt="Mini Marvels gallery" loading="lazy" width="300" height="300">
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="footer-grid">
                    {{-- Brand + contact --}}
                    <div class="footer-brand">
                        <img src="{{ asset('images/logo.png') }}" alt="Mini Marvels" width="160" height="64" class="footer-logo">
                        <ul class="footer-contact">
                            <li>
                                <span class="fc-icon" aria-hidden="true">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 10.5L12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-9.5z"/></svg>
                                </span>
                                No: 58 A, East Madison Street, Baltimore, MD, USA 4508
                            </li>
                            <li>
                                <span class="fc-icon" aria-hidden="true">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v2a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h2a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.6a2 2 0 0 1-.5 2.1L7.1 9.5a16 16 0 0 0 6 6l1.1-1.1a2 2 0 0 1 2.1-.5c.8.3 1.7.5 2.6.6A2 2 0 0 1 22 16.9z"/></svg>
                                </span>
                                +00 (0) 123 456 789
                            </li>
                            <li>
                                <span class="fc-icon" aria-hidden="true">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
                                </span>
                                contact@example.com
                            </li>
                        </ul>
                        <svg class="footer-rainbow" viewBox="0 0 90 50" aria-hidden="true">
                            <path d="M8 42 A32 32 0 0 1 82 42" stroke="#F7A8C5" stroke-width="5" fill="none" stroke-linecap="round"/>
                            <path d="M15 42 A25 25 0 0 1 75 42" stroke="#F5A26B" stroke-width="5" fill="none" stroke-linecap="round"/>
                            <path d="M22 42 A18 18 0 0 1 68 42" stroke="#F5D76E" stroke-width="5" fill="none" stroke-linecap="round"/>
                            <path d="M29 42 A11 11 0 0 1 61 42" stroke="#A8E6CF" stroke-width="5" fill="none" stroke-linecap="round"/>
                            <ellipse cx="10" cy="42" rx="8" ry="5" fill="#fff"/>
                        </svg>
                    </div>

                    {{-- Useful links + Delivery --}}
                    <div class="footer-col">
                        <h4>Useful Links</h4>
                        <a href="#newsletter">Contact Us</a>
                        <a href="#">About Us</a>
                        <a href="#">Shipping &amp; Returns</a>
                        <a href="#">Refund Policy</a>

                        <h4 class="footer-col-gap">Delivery</h4>
                        <a href="#">Free Delivery</a>
                        <a href="#">FAQ</a>
                    </div>

                    {{-- Customer service + social --}}
                    <div class="footer-col">
                        <h4>Customer Service</h4>
                        <a href="#cart">Orders</a>
                        <a href="#login">Addresses</a>
                        <a href="#login">Account Details</a>
                        <a href="#">24x7 Calls</a>

                        <h4 class="footer-col-gap">Social Media</h4>
                        <div class="footer-social">
                            <a href="#" aria-label="X">X</a>
                            <a href="#" aria-label="Instagram">Ig</a>
                            <a href="#" aria-label="Facebook">Fb</a>
                            <a href="#" aria-label="YouTube">Yt</a>
                        </div>
                    </div>

                    {{-- Newsletter --}}
                    <div class="footer-col footer-newsletter">
                        <h4>Newsletter Subscription</h4>
                        <form class="footer-news-form" onsubmit="event.preventDefault();">
                            <input type="email" name="email" placeholder="Your E-mail here" aria-label="Email" required>
                            <button type="submit" aria-label="Subscribe">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M2 21l21-9L2 3v7l15 2-15 2v7z"/></svg>
                            </button>
                        </form>
                        <p class="footer-news-note">Join our list and get 15% off your first purchase!</p>
                        <div class="footer-news-art" aria-hidden="true">
                            <img
                                src="https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=240&h=240&fit=crop"
                                alt=""
                                width="120"
                                height="120"
                                loading="lazy"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bar">
            <div class="container footer-bar-inner">
                <p>&copy; {{ date('Y') }} Mini Marvels. All Rights Reserved.</p>
                <div class="footer-payments" aria-label="Payment methods">
                    <span>Visa</span>
                    <span>Mastercard</span>
                    <span>PayPal</span>
                    <span>Skrill</span>
                    <span>Payoneer</span>
                    <span>Amazon Pay</span>
                    <span>Google Pay</span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.querySelector('.hero-swiper')) {
                new Swiper('.hero-swiper', {
                    loop: true,
                    speed: 700,
                    autoplay: { delay: 5000, disableOnInteraction: false },
                    navigation: {
                        nextEl: '.hero-next',
                        prevEl: '.hero-prev',
                    },
                });
            }

            if (document.querySelector('.category-swiper')) {
                new Swiper('.category-swiper', {
                    slidesPerView: 2,
                    navigation: {
                        nextEl: '.category-next',
                        prevEl: '.category-prev',
                    },
                    breakpoints: {
                        640: { slidesPerView: 3 },
                        900: { slidesPerView: 4 },
                        1200: { slidesPerView: 6 },
                    },
                });
            }

            if (document.querySelector('.testimonial-swiper')) {
                new Swiper('.testimonial-swiper', {
                    loop: true,
                    speed: 550,
                    autoplay: { delay: 5500, disableOnInteraction: false },
                    pagination: {
                        el: '.testimonial-pagination',
                        clickable: true,
                    },
                });
            }

            if (document.querySelector('.product-main-swiper')) {
                const productThumbs = new Swiper('.product-thumb-swiper', {
                    slidesPerView: 4,
                    spaceBetween: 10,
                    freeMode: true,
                    watchSlidesProgress: true,
                    slideToClickedSlide: true,
                    breakpoints: {
                        768: {
                            direction: 'vertical',
                            slidesPerView: 4,
                        },
                    },
                });

                new Swiper('.product-main-swiper', {
                    spaceBetween: 10,
                    grabCursor: true,
                    keyboard: { enabled: true },
                    thumbs: { swiper: productThumbs },
                });
            }
        });
    </script>

    @livewireScripts
</body>
</html>
