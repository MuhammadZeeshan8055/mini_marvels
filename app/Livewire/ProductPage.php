<?php

namespace App\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;

class ProductPage extends Component
{
    public string $slug = '';

    public function mount(?string $slug = null): void
    {
        $this->slug = $slug ?: 'push-ride-on-car';
    }

    public function render()
    {
        $products = $this->products();
        $product = collect($products)->first(
            fn (array $item) => Str::slug($item['name']) === $this->slug
        ) ?? $products[5];

        $related = collect($products)
            ->reject(fn (array $item) => $item['name'] === $product['name'])
            ->take(4)
            ->values()
            ->all();

        return view('livewire.product-page', compact('product', 'related'))
            ->layout('layouts.app', [
                'title' => $product['name'].' — Mini Marvels',
                'metaDescription' => 'Shop '.$product['name'].' at Mini Marvels.',
            ]);
    }

    private function products(): array
    {
        return [
            ['name' => 'Stuffed Deer Toy', 'category' => 'Stuffed Dolls', 'price' => 21.55, 'image' => 'https://images.unsplash.com/photo-1559454403-b8fb88521f11?w=900&h=900&fit=crop'],
            ['name' => 'Wooden Rocking Horse', 'category' => 'Wood Toys', 'price' => 15.60, 'image' => 'https://images.unsplash.com/photo-1594787318286-3d835c1d207f?w=900&h=900&fit=crop'],
            ['name' => 'Funny Teddy', 'category' => 'Learning Toys', 'price' => 20.50, 'image' => 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?w=900&h=900&fit=crop'],
            ['name' => 'Woolen Baby Girl', 'category' => 'Stuffed Dolls', 'price' => 21.70, 'image' => 'https://images.unsplash.com/photo-1618842676088-c4d48a6a7c9d?w=900&h=900&fit=crop'],
            ['name' => 'Fancy Teddy Bear', 'category' => 'Stuffed Dolls', 'price' => 20.85, 'image' => 'https://images.unsplash.com/photo-1545558014-8692077e9b5c?w=900&h=900&fit=crop'],
            ['name' => 'Push Ride On Car', 'category' => 'Play Toys', 'price' => 25.25, 'image' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=900&h=900&fit=crop'],
            ['name' => 'Baby Stroller Toy', 'category' => 'Play Toys', 'price' => 24.85, 'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=900&h=900&fit=crop'],
            ['name' => 'Handmade Teddy Bear', 'category' => 'Stuffed Dolls', 'price' => 23.60, 'image' => 'https://images.unsplash.com/photo-1598880940080-ff9a29891b85?w=900&h=900&fit=crop'],
        ];
    }
}
