<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductImage;
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

        $colors = $productModel->images->map(fn (ProductImage $image, int $index) => [
            'name' => $image->color_name ?: 'Color '.($index + 1),
            'hex' => $image->color_hex ?: '#d5b08a',
            'image' => $image->url(),
        ])->values()->all();

        if ($colors === []) {
            $colors = [
                [
                    'name' => 'Original',
                    'hex' => '#d5b08a',
                    'image' => $productModel->imageUrl(),
                ],
            ];
        }

        $product = [
            'name' => $productModel->name,
            'slug' => $productModel->slug,
            'category' => $productModel->category?->name ?? 'Toys',
            'age' => $productModel->age,
            'price' => (float) $productModel->price,
            'image' => $colors[0]['image'],
            'description' => $productModel->description,
            'stock' => $productModel->stock,
            'colors' => $colors,
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
                    'price' => (float) $item->price,
                    'image' => $colors[0]['image'] ?? $item->imageUrl(),
                    'colors' => $colors,
                ];
            })
            ->all();

        return view('livewire.product-page', compact('product', 'related'))
            ->layout('layouts.app', [
                'title' => $product['name'].' — Mini Marvels',
                'metaDescription' => 'Shop '.$product['name'].' at Mini Marvels.',
            ]);
    }
}
