<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use App\Support\HtmlSanitizer;
use Livewire\Component;

class ContactPage extends Component
{
    public string $title = '';

    public string $content = '';

    public string $address = '';

    public string $phone = '';

    public string $email = '';

    public bool $show_form = true;

    public string $form_note = '';

    public string $meta_title = '';

    public string $meta_description = '';

    public function mount(): void
    {
        $page = Page::findBySlug('contact') ?? Page::create([
            'slug' => 'contact',
            'title' => 'Contact Us',
            'content' => '<p>Dummy contact content. Edit this from admin.</p>',
            'extras' => [
                'address' => 'No: 58 A, East Madison Street, Baltimore, MD, USA 4508',
                'phone' => '+00 (0) 123 456 789',
                'email' => 'contact@example.com',
                'show_form' => true,
                'form_note' => 'This form is a preview for now — messages are not sent yet.',
            ],
        ]);

        $this->title = $page->title;
        $this->content = $page->content ?? '';
        $this->address = (string) $page->extra('address', '');
        $this->phone = (string) $page->extra('phone', '');
        $this->email = (string) $page->extra('email', '');
        $this->show_form = (bool) $page->extra('show_form', true);
        $this->form_note = (string) $page->extra('form_note', '');
        $this->meta_title = $page->meta_title ?? '';
        $this->meta_description = $page->meta_description ?? '';
    }

    public function save(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'min:2', 'max:150'],
            'content' => ['nullable', 'string', 'max:50000'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:150'],
            'show_form' => ['boolean'],
            'form_note' => ['nullable', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:160'],
        ]);

        $page = Page::findBySlug('contact');

        if (! $page) {
            $page = new Page(['slug' => 'contact']);
        }

        $page->fill([
            'title' => $this->title,
            'content' => HtmlSanitizer::clean($this->content),
            'meta_title' => $this->meta_title !== '' ? $this->meta_title : null,
            'meta_description' => $this->meta_description !== '' ? $this->meta_description : null,
            'extras' => [
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
                'show_form' => $this->show_form,
                'form_note' => $this->form_note,
            ],
        ]);

        $page->save();

        $this->dispatch('toast', message: 'Contact page saved', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.contact-page')->layout('layouts.admin', [
            'title' => 'Contact Us',
        ]);
    }
}
