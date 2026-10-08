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
    <header class="site-header" x-data="{ open: false }">
        <div class="header-inner">
            <div class="flex items-center gap-2">
                <button type="button" class="menu-toggle icon-btn" @click="open = !open" aria-label="Open menu">
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

                <a href="#cart" class="icon-btn" aria-label="Cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 8h12l-1 11H7L6 8z"/><path stroke-linecap="round" d="M9 8a3 3 0 0 1 6 0"/>
                    </svg>
                    <span class="badge">2</span>
                </a>

                <a href="#wishlist" class="icon-btn" aria-label="Wishlist">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20s-7-4.5-7-9.5A4 4 0 0 1 12 7a4 4 0 0 1 7 3.5C19 15.5 12 20 12 20z"/>
                    </svg>
                    <span class="badge">0</span>
                </a>
            </div>
        </div>

        <nav class="mobile-nav" :class="{ 'open': open }" aria-label="Mobile">
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
        <div class="container footer-grid">
            <div class="footer-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Mini Marvels" width="140" height="56">
                <p>Kids toys & deals that spark creativity and play.</p>
                <p style="margin-top:0.75rem;">contact@minimarvels.test</p>
            </div>

            <div class="footer-col">
                <h4>Useful Links</h4>
                <a href="#">About Us</a>
                <a href="#">Shipping & Returns</a>
                <a href="#">Refund Policy</a>
                <a href="#newsletter">Contact Us</a>
            </div>

            <div class="footer-col">
                <h4>Delivery</h4>
                <a href="#">Free Delivery</a>
                <a href="#">FAQ</a>
            </div>

            <div class="footer-col">
                <h4>Customer Service</h4>
                <a href="#cart">Orders</a>
                <a href="#login">Account Details</a>
                <a href="#">24x7 Support</a>
            </div>
        </div>

        <div class="container footer-bottom">
            &copy; {{ date('Y') }} Mini Marvels. All Rights Reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.querySelector('.hero-swiper')) {
                new Swiper('.hero-swiper', {
                    loop: true,
                    autoplay: { delay: 4500, disableOnInteraction: false },
                    pagination: { el: '.hero-swiper .swiper-pagination', clickable: true },
                    navigation: {
                        nextEl: '.hero-swiper .swiper-button-next',
                        prevEl: '.hero-swiper .swiper-button-prev',
                    },
                });
            }
        });
    </script>

    @livewireScripts
</body>
</html>
