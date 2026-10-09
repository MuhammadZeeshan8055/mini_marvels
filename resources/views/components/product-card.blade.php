@props([
    'name',
    'category',
    'price',
    'image',
    'age' => null,
])

<article {{ $attributes->class('shop-product-card') }}>
    <a class="shop-product-image" href="{{ route('product.show', ['slug' => \Illuminate\Support\Str::slug($name)]) }}">
        <img src="{{ $image }}" alt="{{ $name }}" loading="lazy" width="520" height="520">
        @if ($age)
            <span>{{ $age }}</span>
        @endif
    </a>
    <div class="shop-product-copy">
        <small>{{ $category }}</small>
        <h3><a href="{{ route('product.show', ['slug' => \Illuminate\Support\Str::slug($name)]) }}">{{ $name }}</a></h3>
        <strong>${{ number_format($price, 2) }}</strong>
    </div>
</article>
