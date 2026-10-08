<?php

namespace App\Livewire;

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
        return [
            ['name' => 'Playsets', 'emoji' => '🏰'],
            ['name' => 'Action Figures', 'emoji' => '🦸'],
            ['name' => 'Toddler Toys', 'emoji' => '🧸'],
            ['name' => 'Building Sets', 'emoji' => '🧱'],
            ['name' => 'Puzzles', 'emoji' => '🧩'],
            ['name' => 'Kids Books', 'emoji' => '📚'],
            ['name' => 'Kids Electronics', 'emoji' => '🎮'],
            ['name' => 'Outdoor Toys', 'emoji' => '⚽'],
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
        return [
            'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1594787318286-3d835c1d207f?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1618842676088-c4d48a6a7c9d?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1516627145497-ae6968895b74?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1598880940080-ff9a29891b85?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1588072432836-e10032774350?w=600&h=600&fit=crop',
            'https://images.unsplash.com/photo-1610890716171-6b1bb98ffd09?w=600&h=600&fit=crop',
        ];
    }

    private function products(): array
    {
        return [
            ['name' => 'Stuffed Deer Toy', 'category' => 'Stuffed Dolls', 'price' => 21.55, 'image' => 'https://images.unsplash.com/photo-1559454403-b8fb88521f11?w=700&h=700&fit=crop'],
            ['name' => 'Wooden Rocking Horse', 'category' => 'Wood Toys', 'price' => 15.60, 'image' => 'https://images.unsplash.com/photo-1594787318286-3d835c1d207f?w=700&h=700&fit=crop'],
            ['name' => 'Funny Teddy', 'category' => 'Learning Toys', 'price' => 20.50, 'image' => 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?w=700&h=700&fit=crop'],
            ['name' => 'Woolen Baby Girl', 'category' => 'Stuffed Dolls', 'price' => 21.70, 'image' => 'https://images.unsplash.com/photo-1618842676088-c4d48a6a7c9d?w=700&h=700&fit=crop'],
            ['name' => 'Fancy Teddy Bear', 'category' => 'Stuffed Dolls', 'price' => 20.85, 'image' => 'https://images.unsplash.com/photo-1545558014-8692077e9b5c?w=700&h=700&fit=crop'],
            ['name' => 'Push Ride On Car', 'category' => 'Play Toys', 'price' => 25.25, 'image' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=700&h=700&fit=crop'],
            ['name' => 'Baby Stroller Toy', 'category' => 'Play Toys', 'price' => 24.85, 'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=700&h=700&fit=crop'],
            ['name' => 'Handmade Teddy Bear', 'category' => 'Stuffed Dolls', 'price' => 23.60, 'image' => 'https://images.unsplash.com/photo-1598880940080-ff9a29891b85?w=700&h=700&fit=crop'],
        ];
    }

    private function featured(): array
    {
        return [
            ['name' => 'Push Ride On Car', 'category' => 'Play Toys', 'price' => 25.25, 'image' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=700&h=700&fit=crop'],
            ['name' => 'Baby Stroller Toy', 'category' => 'Play Toys', 'price' => 24.85, 'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=700&h=700&fit=crop'],
            ['name' => 'Building Blocks', 'category' => 'Play Toys', 'price' => 15.85, 'image' => 'https://images.unsplash.com/photo-1618842676088-c4d48a6a7c9d?w=700&h=700&fit=crop'],
            ['name' => 'Toddler Truck Toy', 'category' => 'Play Toys', 'price' => 14.65, 'image' => 'https://images.unsplash.com/photo-1594787318286-3d835c1d207f?w=700&h=700&fit=crop'],
        ];
    }

    private function promos(): array
    {
        return [
            ['title' => 'All That Your Child Wish For', 'subtitle' => 'Outdoor Toys', 'price' => 'Starts @ $5.00', 'bg' => '#F8BCC7', 'text' => '#171418', 'image' => 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=600&h=700&fit=crop'],
            ['title' => 'Colorful Friction Powered Toys', 'subtitle' => 'Up to 50% Off On', 'price' => 'Only $19.99', 'bg' => '#A9E28F', 'text' => '#171418', 'image' => 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?w=600&h=700&fit=crop'],
            ['title' => "Let's Improve Kids Motor Skills", 'subtitle' => 'Learning Fun', 'price' => 'Only $15.55', 'bg' => '#6544A8', 'text' => '#FFFFFF', 'image' => 'https://images.unsplash.com/photo-1599443015574-be5fe8a05783?w=600&h=700&fit=crop'],
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
