<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Component;

class ProductPage extends Component
{
    public string $slug = '';

    public function mount(?string $slug = null): void
    {
        $this->slug = $slug ?: '';
    }

    public function render()
    {
        $productModel = Product::query()
            ->with(['category', 'images'])
            ->active()
            ->when($this->slug !== '', fn ($q) => $q->where('slug', $this->slug))
            ->first();

        if (! $productModel) {
            $productModel = Product::query()->with(['category', 'images'])->active()->first();
        }

        if (! $productModel) {
            abort(404, 'No products found.');
        }

        $colors = $productModel->colorVariants();

        $product = [
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

        return view('livewire.product-page', compact('product', 'related'))
            ->layout('layouts.app', [
                'title' => $pageTitle,
                'metaDescription' => $pageDescription,
                'metaKeywords' => $productModel->meta_keywords,
                'ogType' => 'product',
                'ogImage' => $ogImage,
            ]);
    }
}
