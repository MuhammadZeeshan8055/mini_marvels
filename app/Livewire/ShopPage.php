<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;

class ShopPage extends Component
{
    public string $search = '';

    public string $category = 'All';

    #[Url]
    public string $age = 'All';

    public int $maxPrice = 10000;

    public string $sort = 'featured';

    public function resetFilters(): void
    {
        $this->reset('search', 'category', 'age', 'sort');
        $this->maxPrice = 10000;
    }

    public function getFilteredProductsProperty(): Collection
    {
        $query = Product::query()
            ->with(['category', 'images'])
            ->active()
            ->when($this->search !== '', function ($q) {
                $term = '%'.$this->search.'%';
                $q->where(function ($inner) use ($term) {
                    $inner->where('name', 'like', $term)
                        ->orWhere('description', 'like', $term);
                });
            })
            ->when($this->category !== 'All', function ($q) {
                $q->whereHas('category', fn ($c) => $c->where('name', $this->category));
            })
            ->when($this->age !== 'All', fn ($q) => $q->where('age', $this->age))
            ->where('price', '<=', $this->maxPrice);

        $products = match ($this->sort) {
            'price-low' => $query->orderBy('price')->get(),
            'price-high' => $query->orderByDesc('price')->get(),
            'name' => $query->orderBy('name')->get(),
            default => $query->orderByDesc('is_featured')->orderBy('name')->get(),
        };

        return $products->map(function (Product $product) {
            $colors = $product->colorVariants();

            return [
                'name' => $product->name,
                'slug' => $product->slug,
                'category' => $product->category?->name ?? 'Toys',
                'age' => $product->age,
                'price' => $product->salePrice(),
                'official_price' => $product->onSale() ? $product->officialPrice() : null,
                'image' => $colors[0]['image'] ?? $product->imageUrl(),
                'colors' => $colors,
            ];
        });
    }

    public function getCategoryCountsProperty(): array
    {
        return Product::query()
            ->active()
            ->with('category')
            ->get()
            ->countBy(fn (Product $product) => $product->category?->name ?? 'Toys')
            ->all();
    }

    public function render()
    {
        $categoryNames = Category::orderBy('name')->pluck('name')->all();

        if ($categoryNames === []) {
            $categoryNames = array_keys($this->categoryCounts);
        }

        return view('livewire.shop-page', [
            'categories' => $categoryNames,
            'ages' => ['0-2 Years', '3-4 Years', '3-8 Years', '5-7 Years', '8-10 Years', '10+ Years'],
        ])->layout('layouts.app', [
            'title' => 'Shop Toys — Mini Marvels',
            'metaDescription' => 'Explore toys for every age and imagination at Mini Marvels.',
        ]);
    }
}
