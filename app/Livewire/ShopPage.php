<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;

class ShopPage extends Component
{
    public string $search = '';

    public string $category = 'All';

    #[Url]
    public string $age = 'All';

    public int $maxPrice = 80;

    public string $sort = 'featured';

    public function resetFilters(): void
    {
        $this->reset('search', 'category', 'age', 'sort');
        $this->maxPrice = 80;
    }

    public function getFilteredProductsProperty(): Collection
    {
        $products = collect($this->products())
            ->when($this->search !== '', function (Collection $items): Collection {
                $term = mb_strtolower(trim($this->search));

                return $items->filter(fn (array $item): bool => str_contains(mb_strtolower($item['name'].' '.$item['category']), $term)
                );
            })
            ->when($this->category !== 'All', fn (Collection $items): Collection => $items->where('category', $this->category)
            )
            ->when($this->age !== 'All', fn (Collection $items): Collection => $items->where('age', $this->age)
            )
            ->filter(fn (array $item): bool => $item['price'] <= $this->maxPrice);

        return match ($this->sort) {
            'price-low' => $products->sortBy('price')->values(),
            'price-high' => $products->sortByDesc('price')->values(),
            'name' => $products->sortBy('name')->values(),
            default => $products->values(),
        };
    }

    public function getCategoryCountsProperty(): array
    {
        return collect($this->products())->countBy('category')->all();
    }

    public function render()
    {
        return view('livewire.shop-page', [
            'categories' => array_keys($this->categoryCounts),
            'ages' => ['0-2 Years', '3-4 Years', '5-7 Years', '8-10 Years', '10+ Years'],
        ])->layout('layouts.app', [
            'title' => 'Shop Toys — Mini Marvels',
            'metaDescription' => 'Explore toys for every age and imagination at Mini Marvels.',
        ]);
    }

    private function products(): array
    {
        return [
            ['name' => 'Stuffed Deer Toy', 'category' => 'Stuffed Dolls', 'age' => '3-4 Years', 'price' => 21.55, 'image' => 'https://images.unsplash.com/photo-1559454403-b8fb88521f11?w=700&h=700&fit=crop'],
            ['name' => 'Wooden Rocking Horse', 'category' => 'Wood Toys', 'age' => '3-4 Years', 'price' => 15.60, 'image' => 'https://images.unsplash.com/photo-1594787318286-3d835c1d207f?w=700&h=700&fit=crop'],
            ['name' => 'Funny Teddy', 'category' => 'Learning Toys', 'age' => '0-2 Years', 'price' => 20.50, 'image' => 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?w=700&h=700&fit=crop'],
            ['name' => 'Woolen Baby Girl', 'category' => 'Stuffed Dolls', 'age' => '3-4 Years', 'price' => 21.70, 'image' => 'https://images.unsplash.com/photo-1618842676088-c4d48a6a7c9d?w=700&h=700&fit=crop'],
            ['name' => 'Fancy Teddy Bear', 'category' => 'Stuffed Dolls', 'age' => '0-2 Years', 'price' => 20.85, 'image' => 'https://images.unsplash.com/photo-1545558014-8692077e9b5c?w=700&h=700&fit=crop'],
            ['name' => 'Push Ride On Car', 'category' => 'Ride On Toys', 'age' => '5-7 Years', 'price' => 25.25, 'image' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=700&h=700&fit=crop'],
            ['name' => 'Baby Stroller Toy', 'category' => 'Pretend Play', 'age' => '0-2 Years', 'price' => 24.85, 'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=700&h=700&fit=crop'],
            ['name' => 'Handmade Teddy Bear', 'category' => 'Stuffed Dolls', 'age' => '0-2 Years', 'price' => 23.60, 'image' => 'https://images.unsplash.com/photo-1598880940080-ff9a29891b85?w=700&h=700&fit=crop'],
            ['name' => 'Rainbow Building Blocks', 'category' => 'Learning Toys', 'age' => '3-4 Years', 'price' => 18.40, 'image' => 'https://images.unsplash.com/photo-1598880940080-ff9a29891b85?w=700&h=700&fit=crop'],
            ['name' => 'Classic Board Game', 'category' => 'Games & Puzzles', 'age' => '5-7 Years', 'price' => 28.90, 'image' => 'https://images.unsplash.com/photo-1610890716171-6b1bb98ffd09?w=700&h=700&fit=crop'],
            ['name' => 'Creative Art Kit', 'category' => 'Arts & Crafts', 'age' => '8-10 Years', 'price' => 32.00, 'image' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=700&h=700&fit=crop'],
            ['name' => 'Junior Science Set', 'category' => 'Learning Toys', 'age' => '10+ Years', 'price' => 44.50, 'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=700&h=700&fit=crop'],
        ];
    }
}
