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
                'text' => 'Discover playful learning toys made for curious kids.',
                'bg' => '#FFE8F0',
            ],
            [
                'eyebrow' => 'Educational Programs',
                'title' => "A Perfect Place To Explore Your Kid's Talent",
                'text' => 'Fun picks that help little minds grow every day.',
                'bg' => '#FFF6D6',
            ],
            [
                'eyebrow' => 'Educational Programs',
                'title' => 'Our Best Features and Learn From Anywhere',
                'text' => 'Deals on learning toys, outdoor play, and soft friends.',
                'bg' => '#E8F7FF',
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

    private function products(): array
    {
        return [
            ['name' => 'Stuffed Deer Toy', 'category' => 'Stuffed Dolls', 'price' => 21.55, 'image' => 'https://placehold.co/400x400/FFE8F0/5D3E9F?text=Deer+Toy'],
            ['name' => 'Wooden Rocking Horse', 'category' => 'Wood Toys', 'price' => 15.60, 'image' => 'https://placehold.co/400x400/FFF6D6/5D3E9F?text=Rocking+Horse'],
            ['name' => 'Funny Teddy', 'category' => 'Learning Toys', 'price' => 20.50, 'image' => 'https://placehold.co/400x400/E8F7FF/5D3E9F?text=Funny+Teddy'],
            ['name' => 'Woolen Baby Girl', 'category' => 'Stuffed Dolls', 'price' => 21.70, 'image' => 'https://placehold.co/400x400/F0E8FF/5D3E9F?text=Baby+Girl'],
            ['name' => 'Fancy Teddy Bear', 'category' => 'Stuffed Dolls', 'price' => 20.85, 'image' => 'https://placehold.co/400x400/FFE8F0/5D3E9F?text=Teddy+Bear'],
            ['name' => 'Push Ride On Car', 'category' => 'Play Toys', 'price' => 25.25, 'image' => 'https://placehold.co/400x400/E8FFE8/5D3E9F?text=Ride+On+Car'],
            ['name' => 'Baby Stroller Toy', 'category' => 'Play Toys', 'price' => 24.85, 'image' => 'https://placehold.co/400x400/FFF0E8/5D3E9F?text=Stroller'],
            ['name' => 'Handmade Teddy Bear', 'category' => 'Stuffed Dolls', 'price' => 23.60, 'image' => 'https://placehold.co/400x400/FFE8F0/5D3E9F?text=Handmade'],
        ];
    }

    private function featured(): array
    {
        return [
            ['name' => 'Push Ride On Car', 'category' => 'Play Toys', 'price' => 25.25, 'image' => 'https://placehold.co/400x400/E8FFE8/5D3E9F?text=Ride+On'],
            ['name' => 'Baby Stroller Toy', 'category' => 'Play Toys', 'price' => 24.85, 'image' => 'https://placehold.co/400x400/FFF0E8/5D3E9F?text=Stroller'],
            ['name' => 'Building Blocks', 'category' => 'Play Toys', 'price' => 15.85, 'image' => 'https://placehold.co/400x400/FFF6D6/5D3E9F?text=Blocks'],
            ['name' => 'Toddler Truck Toy', 'category' => 'Play Toys', 'price' => 14.65, 'image' => 'https://placehold.co/400x400/E8F7FF/5D3E9F?text=Truck'],
        ];
    }

    private function promos(): array
    {
        return [
            ['title' => 'All That Your Child Wish For', 'subtitle' => 'Outdoor Toys', 'price' => 'Starts @ $5.00', 'bg' => '#5D3E9F', 'text' => '#fff'],
            ['title' => 'Colorful Friction Powered Toys', 'subtitle' => 'Up to 50% Off On', 'price' => 'Only $19.99', 'bg' => '#F6E27A', 'text' => '#2D2A32'],
            ['title' => "Let's Improve Kids Motor Skills", 'subtitle' => 'Learning Fun', 'price' => 'Only $15.55', 'bg' => '#F7A8C5', 'text' => '#2D2A32'],
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
            ['name' => 'Jessica Lisa', 'role' => 'Parent', 'text' => 'My kids love every toy we ordered. Fast delivery and cute packaging!'],
            ['name' => 'Yoshna', 'role' => 'Teacher', 'text' => 'Great learning toys for the classroom. Quality feels solid and safe.'],
            ['name' => 'Zira Decan', 'role' => 'Parent', 'text' => 'Mini Marvels has become our go-to for birthday gifts and rainy days.'],
        ];
    }
}
