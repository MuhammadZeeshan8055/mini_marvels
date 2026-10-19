<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use App\Models\Page;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class CmsContentSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'eyebrow' => 'Educational Programs',
                'title' => 'Eco-friendly Games & Toys That Foster Creativity',
                'text' => 'Orci ac auctor augue mauris augue neque. Vestibulum ut sodales quam. Ut in vestibulum augue.',
                'image' => 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=900&h=900&fit=crop',
                'button_label' => 'Shop Now',
                'button_url' => '#products',
                'title_dark' => false,
                'eyebrow_box' => false,
                'sort_order' => 0,
            ],
            [
                'eyebrow' => 'Educational Programs',
                'title' => "A Perfect Place To Explore Your Kid's Talent",
                'text' => 'Mauris augue neque. Vestibulum ut sodales quam. Ut in vestibulum augue Orci ac auctor augue.',
                'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=900&h=900&fit=crop',
                'button_label' => 'Shop Now',
                'button_url' => '#products',
                'title_dark' => false,
                'eyebrow_box' => true,
                'sort_order' => 1,
            ],
            [
                'eyebrow' => 'Educational Programs',
                'title' => 'Our Best Features and Learn From Anywhere',
                'text' => 'Vestibulum ut sodales quam. Ut in vestibulum augue. Orci ac auctor augue mauris augue neque.',
                'image' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=900&h=900&fit=crop',
                'button_label' => 'Shop Now',
                'button_url' => '#products',
                'title_dark' => false,
                'eyebrow_box' => false,
                'sort_order' => 2,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::updateOrCreate(
                ['title' => $slide['title']],
                array_merge($slide, ['is_active' => true])
            );
        }

        $testimonials = [
            [
                'name' => 'Jessica Lisa',
                'role' => 'Parent',
                'text' => 'My kids love every toy we ordered. The quality is wonderful, delivery was fast, and the packaging made everything feel extra special.',
                'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=300&h=300&fit=crop',
                'rating' => 5,
                'sort_order' => 0,
            ],
            [
                'name' => 'Yoshna',
                'role' => 'Teacher',
                'text' => 'These learning toys are perfect for our classroom. They feel safe, sturdy, and keep the children happily engaged throughout playtime.',
                'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=300&fit=crop',
                'rating' => 5,
                'sort_order' => 1,
            ],
            [
                'name' => 'Zira Decan',
                'role' => 'Parent',
                'text' => 'Mini Marvels has become our favorite place for birthday gifts and rainy-day activities. Every order has been a lovely experience.',
                'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=300&fit=crop',
                'rating' => 5,
                'sort_order' => 2,
            ],
        ];

        foreach ($testimonials as $item) {
            Testimonial::updateOrCreate(
                ['name' => $item['name']],
                array_merge($item, ['is_active' => true])
            );
        }

        SiteSetting::putValue('footer', SiteSetting::footerDefaults());
        SiteSetting::putValue('testimonials_intro', SiteSetting::testimonialIntroDefaults());

        Page::updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About Us',
                'content' => '<p>Welcome to <strong>Mini Marvels</strong> — a playful home for eco-friendly games and toys that spark creativity.</p><p>We curate safe, joyful products for every age so families can shop with confidence and kids can play with wonder.</p><p>This is placeholder content. You can replace it anytime from the admin panel.</p>',
                'image' => 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=900&h=700&fit=crop',
                'meta_title' => 'About Us — Mini Marvels',
                'meta_description' => 'Learn about Mini Marvels and our mission to bring playful, eco-friendly toys to families.',
                'extras' => [],
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'contact'],
            [
                'title' => 'Contact Us',
                'content' => '<p>We would love to hear from you. Reach out with questions about orders, products, or partnerships.</p><p>Dummy contact details below can be updated from the admin panel whenever you are ready.</p>',
                'image' => null,
                'meta_title' => 'Contact Us — Mini Marvels',
                'meta_description' => 'Get in touch with Mini Marvels for order help, product questions, and support.',
                'extras' => [
                    'address' => 'No: 58 A, East Madison Street, Baltimore, MD, USA 4508',
                    'phone' => '+00 (0) 123 456 789',
                    'email' => 'contact@example.com',
                    'show_form' => true,
                    'form_note' => 'This form is a preview for now — messages are not sent yet.',
                ],
            ]
        );
    }
}
