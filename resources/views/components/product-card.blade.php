{{--
    Simple product card.
    Props: name, category, price, image, age?, slug?, colors? (list of image variants)
--}}
@props([
    'name',
    'category',
    'price',
    'image',
    'age' => null,
    'slug' => null,
    'colors' => [],
    'officialPrice' => null,
])

@php
    // Product link slug
    $linkSlug = $slug ?: \Illuminate\Support\Str::slug($name);
    $productUrl = route('product.show', ['slug' => $linkSlug]);

    // Image list for thumbs (fallback = main image only)
    $thumbs = count($colors) > 0 ? $colors : [
        ['name' => 'Main', 'image' => $image],
    ];

    // Show only first 4 thumbs; rest become "+N"
    $showLimit = 4;
    $visibleThumbs = array_slice($thumbs, 0, $showLimit);
    $moreCount = max(0, count($thumbs) - $showLimit);
@endphp

<article
    {{ $attributes->class('shop-product-card') }}
    x-data="{ activeImage: '{{ $image }}' }"
>
    <div class="shop-product-media">
        {{-- Big image --}}
        <a class="shop-product-image" href="{{ $productUrl }}">
            <img
                :src="activeImage"
                src="{{ $image }}"
                alt="{{ $name }}"
                loading="lazy"
                width="520"
                height="520"
            >
            @if ($age)
                <span>{{ $age }}</span>
            @endif
        </a>

        {{-- Small thumbs in one line --}}
        @if (count($thumbs) > 1)
            <div class="shop-product-swatches">
                @foreach ($visibleThumbs as $thumb)
                    <button
                        type="button"
                        class="shop-product-swatch shop-product-swatch-image"
                        :class="{ 'is-active': activeImage === '{{ $thumb['image'] }}' }"
                        title="{{ $thumb['name'] ?? 'Variant' }}"
                        @click.stop.prevent="activeImage = '{{ $thumb['image'] }}'"
                        @mouseenter="activeImage = '{{ $thumb['image'] }}'"
                    >
                        <img
                            src="{{ $thumb['image'] }}"
                            alt="{{ $thumb['name'] ?? '' }}"
                            width="28"
                            height="28"
                            loading="lazy"
                        >
                    </button>
                @endforeach

                @if ($moreCount > 0)
                    <a
                        href="{{ $productUrl }}"
                        class="shop-product-swatch shop-product-swatch-more"
                        title="+{{ $moreCount }} more"
                        @click.stop
                    >
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                        </svg>
                        <span>+{{ $moreCount }}</span>
                    </a>
                @endif
            </div>
        @endif
    </div>

    <div class="shop-product-copy">
        <small>{{ $category }}</small>
        <h3><a href="{{ $productUrl }}">{{ $name }}</a></h3>
        <div class="shop-product-price">
            @if ($officialPrice !== null && (float) $officialPrice > (float) $price)
                <s>${{ number_format((float) $officialPrice, 2) }}</s>
            @endif
            <strong>${{ number_format((float) $price, 2) }}</strong>
        </div>
    </div>
</article>
