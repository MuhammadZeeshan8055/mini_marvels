@props([
    'name',
    'category',
    'price',
    'image',
])

<a class="product-card" href="{{ route('product.show', ['slug' => \Illuminate\Support\Str::slug($name)]) }}">
    <div class="product-card-inner">
        <div class="product-image-wrap">
            <img src="{{ $image }}" alt="{{ $name }}" loading="lazy" width="500" height="500">
        </div>
        <div class="product-body">
            <span class="product-cat">{{ $category }}</span>
            <h3 class="product-name">{{ $name }}</h3>
            <div class="product-price">${{ number_format($price, 2) }}</div>
        </div>
    </div>
</a>
