<?php

namespace App\Livewire;

use App\Models\Page;
use Livewire\Component;

class ContactPage extends Component
{
    public string $name = '';

    public string $email = '';

    public string $message = '';

    public function submit(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        $this->reset(['name', 'email', 'message']);
        session()->flash('contact_success', 'Thanks! This form is a preview for now — your message was not sent.');
    }

    public function render()
    {
        $page = Page::findBySlug('contact');

        return view('livewire.contact-page', [
            'page' => $page,
        ])->layout('layouts.app', [
            'title' => $page?->meta_title ?: ($page?->title ?: 'Contact Us').' — Mini Marvels',
            'metaDescription' => $page?->meta_description
                ?: 'Get in touch with Mini Marvels for order help, product questions, and support.',
        ]);
    }
}
