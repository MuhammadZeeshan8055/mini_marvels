<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        return view('livewire.home-page', [
            'slides' => $this->slides(),
            'categories' => $this->categories(),
            'categoryImages' => $this->categoryImages(),
            'ages' => $this->ages(),
            'products' => $this->products(),
            'featured' => $this->featured(),
            'promos' => $this->promos(),
            'trust' => $this->trust(),
            'testimonials' => $this->testimonials(),
        ])->layout('layouts.app', [
            'title' => 'Mini Marvels — Kids Toys & Deals',
            'metaDescription' => 'Shop eco-friendly games and toys that foster creativity. Deals on toddler toys, puzzles, learning toys and more at Mini Marvels.',
        ]);
    }

    private function mapProduct(Product $product): array
    {
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
    }

    private function slides(): array
    {
        return [
            [
                'eyebrow' => 'Educational Programs',
                'title' => 'Eco-friendly Games & Toys That Foster Creativity',
                'text' => 'Orci ac auctor augue mauris augue neque. Vestibulum ut sodales quam. Ut in vestibulum augue.',
                'image' => 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=900&h=900&fit=crop',
                'title_dark' => false,
                'eyebrow_box' => false,
            ],
            [
                'eyebrow' => 'Educational Programs',
                'title' => "A Perfect Place To Explore Your Kid's Talent",
                'text' => 'Mauris augue neque. Vestibulum ut sodales quam. Ut in vestibulum augue Orci ac auctor augue.',
                'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=900&h=900&fit=crop',
                'title_dark' => false,
                'eyebrow_box' => true,
            ],
            [
                'eyebrow' => 'Educational Programs',
                'title' => 'Our Best Features and Learn From Anywhere',
                'text' => 'Vestibulum ut sodales quam. Ut in vestibulum augue. Orci ac auctor augue mauris augue neque.',
                'image' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=900&h=900&fit=crop',
                'title_dark' => false,
                'eyebrow_box' => false,
            ],
        ];
    }

    private function categories(): array
    {
        $fromDb = Category::orderBy('name')->get()->map(fn (Category $category) => [
            'name' => $category->name,
            'emoji' => $category->emoji ?: '🧸',
        ])->all();

        if ($fromDb !== []) {
            return $fromDb;
        }

        return [
            ['name' => 'Playsets', 'emoji' => '🏰'],
            ['name' => 'Learning Toys', 'emoji' => '🧠'],
            ['name' => 'Games', 'emoji' => '🎲'],
        ];
    }

    private function ages(): array
    {
        return [
            ['label' => '0-2 Years', 'color' => '#F7A8C5'],
            ['label' => '3-4 Years', 'color' => '#F6E27A'],
            ['label' => '5-7 Years', 'color' => '#A8E6CF'],
            ['label' => '8-10 Years', 'color' => '#A8D8FF'],
            ['label' => '10+ Years', 'color' => '#D4C1FF'],
        ];
    }

    private function categoryImages(): array
    {
        $fallback = 'https://placehold.co/600x600/FFE8F0/5D3E9F?text=Toys';

        return Category::orderBy('name')->get()->map(function (Category $category) use ($fallback) {
            $product = $category->products()->whereNotNull('image')->active()->first();

            return $product?->imageUrl() ?? $fallback;
        })->all();
    }

    private function products(): array
    {
        return Product::query()
            ->with(['category', 'images'])
            ->active()
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->take(8)
            ->get()
            ->map(fn (Product $product) => $this->mapProduct($product))
            ->all();
    }

    private function featured(): array
    {
        $featured = Product::query()
            ->with(['category', 'images'])
            ->active()
            ->featured()
            ->take(4)
            ->get();

        if ($featured->isEmpty()) {
            $featured = Product::query()->with(['category', 'images'])->active()->take(4)->get();
        }

        return $featured->map(fn (Product $product) => $this->mapProduct($product))->all();
    }

    private function promos(): array
    {
        return [
            ['title' => 'All That Your Child Wish For', 'subtitle' => 'Outdoor Toys', 'price' => 'Starts @ Rs 350', 'bg' => '#F8BCC7', 'text' => '#171418', 'image' => 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=600&h=700&fit=crop'],
            ['title' => 'Colorful Friction Powered Toys', 'subtitle' => 'Up to 50% Off On', 'price' => 'From Rs 299', 'bg' => '#A9E28F', 'text' => '#171418', 'image' => 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?w=600&h=700&fit=crop'],
            ['title' => "Let's Improve Kids Motor Skills", 'subtitle' => 'Learning Fun', 'price' => 'From Rs 410', 'bg' => '#6544A8', 'text' => '#FFFFFF', 'image' => 'https://images.unsplash.com/photo-1599443015574-be5fe8a05783?w=600&h=700&fit=crop'],
        ];
    }

    private function trust(): array
    {
        return [
            ['title' => 'Secured Payments', 'text' => 'Safe checkout every time.', 'emoji' => '🔒'],
            ['title' => 'Easy Return Policy', 'text' => 'Hassle-free returns.', 'emoji' => '↩️'],
            ['title' => 'Free Shipping', 'text' => 'On orders up to $49.', 'emoji' => '🚚'],
            ['title' => 'Online Support', 'text' => 'We are here to help.', 'emoji' => '💬'],
        ];
    }

    private function testimonials(): array
    {
        return [
            ['name' => 'Jessica Lisa', 'role' => 'Parent', 'text' => 'My kids love every toy we ordered. The quality is wonderful, delivery was fast, and the packaging made everything feel extra special.', 'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=300&h=300&fit=crop'],
            ['name' => 'Yoshna', 'role' => 'Teacher', 'text' => 'These learning toys are perfect for our classroom. They feel safe, sturdy, and keep the children happily engaged throughout playtime.', 'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=300&fit=crop'],
            ['name' => 'Zira Decan', 'role' => 'Parent', 'text' => 'Mini Marvels has become our favorite place for birthday gifts and rainy-day activities. Every order has been a lovely experience.', 'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=300&fit=crop'],
        ];
    }
}
