<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\Cart;
use App\Services\Wishlist;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductPage extends Component
{
    public string $slug = '';

    public ?int $productId = null;

    public int $selectedVariantIndex = 0;

    public int $quantity = 1;

    public string $addedMessage = '';

    public function mount(?string $slug = null): void
    {
        $this->slug = $slug ?: '';

        $product = Product::query()
            ->active()
            ->when($this->slug !== '', fn ($q) => $q->where('slug', $this->slug))
            ->first();

        if (! $product) {
            $product = Product::query()->active()->first();
        }

        $this->productId = $product?->id;
    }

    public function selectVariant(int $index): void
    {
        $this->selectedVariantIndex = max(0, $index);
        $this->addedMessage = '';
    }

    public function decreaseQuantity(): void
    {
        $this->quantity = max(1, $this->quantity - 1);
    }

    public function increaseQuantity(): void
    {
        $this->quantity++;
    }

    public function addToCart(): void
    {
        $product = Product::query()->with('images')->active()->find($this->productId);

        if (! $product) {
            return;
        }

        if ($product->stock < 1) {
            $this->addedMessage = 'Sorry, this item is out of stock.';

            return;
        }

        $variants = $product->colorVariants();
        $variant = $variants[$this->selectedVariantIndex] ?? $variants[0] ?? null;

        Cart::add($product, max(1, $this->quantity), $variant);
        $this->dispatch('cart-updated');

        $color = $variant['name'] ?? null;
        $this->addedMessage = $color
            ? "Added {$color} to cart!"
            : 'Added to cart!';
    }

    public function toggleWishlist(): void
    {
        $product = Product::query()->active()->find($this->productId);

        if (! $product) {
            return;
        }

        $added = Wishlist::toggle($product);
        $this->dispatch('wishlist-updated');
        $this->addedMessage = $added ? 'Added to wishlist!' : 'Removed from wishlist.';
    }

    public function getInWishlistProperty(): bool
    {
        return $this->productId ? Wishlist::has($this->productId) : false;
    }

    #[On('wishlist-updated')]
    public function refreshWishlistState(): void
    {
        // Sync heart button when wishlist changes elsewhere.
    }

    public function render()
    {
        $productModel = Product::query()
            ->with(['category', 'images'])
            ->active()
            ->when($this->productId, fn ($q) => $q->where('id', $this->productId))
            ->when(! $this->productId && $this->slug !== '', fn ($q) => $q->where('slug', $this->slug))
            ->first();

        if (! $productModel) {
            $productModel = Product::query()->with(['category', 'images'])->active()->first();
        }

        if (! $productModel) {
            abort(404, 'No products found.');
        }

        $this->productId = $productModel->id;

        $colors = $productModel->colorVariants();

        if ($this->selectedVariantIndex >= count($colors)) {
            $this->selectedVariantIndex = 0;
        }

        $product = [
            'id' => $productModel->id,
            'name' => $productModel->name,
            'slug' => $productModel->slug,
            'category' => $productModel->category?->name ?? 'Toys',
            'age' => $productModel->age,
            'price' => $productModel->salePrice(),
            'official_price' => $productModel->onSale() ? $productModel->officialPrice() : null,
            'on_sale' => $productModel->onSale(),
            'image' => $colors[0]['image'] ?? $productModel->imageUrl(),
            'description' => $productModel->description,
            'stock' => $productModel->stock,
            'colors' => $colors,
            'has_colors' => collect($colors)->contains(fn (array $c) => ! empty($c['has_color'])),
        ];

        $related = Product::query()
            ->with(['category', 'images'])
            ->active()
            ->where('id', '!=', $productModel->id)
            ->when($productModel->category_id, fn ($q) => $q->where('category_id', $productModel->category_id))
            ->take(4)
            ->get()
            ->map(function (Product $item) {
                $colors = $item->colorVariants();

                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'slug' => $item->slug,
                    'category' => $item->category?->name ?? 'Toys',
                    'age' => $item->age,
                    'price' => $item->salePrice(),
                    'official_price' => $item->onSale() ? $item->officialPrice() : null,
                    'image' => $colors[0]['image'] ?? $item->imageUrl(),
                    'colors' => $colors,
                ];
            })
            ->all();

        $pageTitle = $productModel->meta_title
            ?: ($product['name'].' — Mini Marvels');

        $pageDescription = $productModel->meta_description
            ?: ($productModel->description
                ? Str::limit(strip_tags($productModel->description), 155)
                : 'Shop '.$product['name'].' at Mini Marvels.');

        $ogImage = $product['image'];
        if ($ogImage && ! str_starts_with($ogImage, 'http://') && ! str_starts_with($ogImage, 'https://')) {
            $ogImage = url($ogImage);
        }

        $productUrl = route('product.show', $productModel->slug);
        $availability = $productModel->stock > 0
            ? 'https://schema.org/InStock'
            : 'https://schema.org/OutOfStock';

        $productSchema = [
            '@type' => 'Product',
            '@id' => $productUrl.'#product',
            'name' => $product['name'],
            'description' => $pageDescription,
            'sku' => (string) $productModel->id,
            'url' => $productUrl,
            'image' => array_values(array_filter([
                $ogImage,
                ...collect($colors)->pluck('image')->map(function ($image) {
                    if (! $image) {
                        return null;
                    }

                    if (! str_starts_with($image, 'http://') && ! str_starts_with($image, 'https://')) {
                        return url($image);
                    }

                    return $image;
                })->all(),
            ])),
            'brand' => [
                '@type' => 'Brand',
                'name' => 'Mini Marvels',
            ],
            'category' => $product['category'],
            'offers' => [
                '@type' => 'Offer',
                'url' => $productUrl,
                'priceCurrency' => 'PKR',
                'price' => number_format((float) $product['price'], 2, '.', ''),
                'availability' => $availability,
                'itemCondition' => 'https://schema.org/NewCondition',
            ],
        ];

        if ($product['official_price']) {
            $productSchema['offers']['priceValidUntil'] = now()->addMonths(3)->toDateString();
        }

        $breadcrumbSchema = [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Shop',
                    'item' => route('shop'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $product['name'],
                    'item' => $productUrl,
                ],
            ],
        ];

        return view('livewire.product-page', compact('product', 'related'))
            ->layout('layouts.app', [
                'title' => $pageTitle,
                'metaDescription' => $pageDescription,
                'metaKeywords' => $productModel->meta_keywords,
                'ogType' => 'website',
                'ogImage' => $ogImage,
                'canonicalUrl' => $productUrl,
                'structuredData' => [$productSchema, $breadcrumbSchema],
            ]);
    }
}
