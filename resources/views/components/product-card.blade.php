@props([
    'name',
    'category',
    'price',
    'image',
])

<article class="product-card">
    <img src="{{ $image }}" alt="{{ $name }}" loading="lazy" width="400" height="400">
    <div class="product-body">
        <span class="product-cat">{{ $category }}</span>
        <h3 class="product-name">{{ $name }}</h3>
        <div class="product-price">${{ number_format($price, 2) }}</div>
        <button type="button" class="btn btn-primary">Add to cart</button>
    </div>
</article>
