<?php

namespace App\Livewire;

use App\Models\Page;
use Livewire\Component;

class AboutPage extends Component
{
    public function render()
    {
        $page = Page::findBySlug('about');

        return view('livewire.about-page', [
            'page' => $page,
        ])->layout('layouts.app', [
            'title' => $page?->meta_title ?: ($page?->title ?: 'About Us').' — Mini Marvels',
            'metaDescription' => $page?->meta_description
                ?: 'Learn about Mini Marvels and our mission to bring playful, eco-friendly toys to families.',
            'ogImage' => $page?->imageUrl(),
        ]);
    }
}
