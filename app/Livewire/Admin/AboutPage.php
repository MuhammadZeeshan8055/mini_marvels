<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use App\Support\HtmlSanitizer;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AboutPage extends Component
{
    use WithFileUploads;

    public string $title = '';

    public string $content = '';

    public string $image_url = '';

    public $image_upload = null;

    public string $meta_title = '';

    public string $meta_description = '';

    public function mount(): void
    {
        $page = Page::findBySlug('about') ?? Page::create([
            'slug' => 'about',
            'title' => 'About Us',
            'content' => '<p>Dummy about content. Edit this from admin.</p>',
            'extras' => [],
        ]);

        $this->title = $page->title;
        $this->content = $page->content ?? '';
        $this->image_url = (is_string($page->image) && str_starts_with($page->image, 'http'))
            ? $page->image
            : '';
        $this->meta_title = $page->meta_title ?? '';
        $this->meta_description = $page->meta_description ?? '';
    }

    public function save(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'min:2', 'max:150'],
            'content' => ['nullable', 'string', 'max:50000'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'image_upload' => ['nullable', 'image', 'max:4096'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:160'],
        ]);

        $page = Page::findBySlug('about');

        if (! $page) {
            $page = new Page(['slug' => 'about']);
        }

        $page->fill([
            'title' => $this->title,
            'content' => HtmlSanitizer::clean($this->content),
            'meta_title' => $this->meta_title !== '' ? $this->meta_title : null,
            'meta_description' => $this->meta_description !== '' ? $this->meta_description : null,
        ]);

        if ($this->image_upload) {
            if ($page->image && ! str_starts_with($page->image, 'http')) {
                Storage::disk('public')->delete($page->image);
            }

            $page->image = $this->image_upload->store('pages', 'public');
            $this->image_upload = null;
        } elseif ($this->image_url !== '' && str_starts_with($this->image_url, 'http')) {
            $page->image = $this->image_url;
        }

        $page->save();

        $this->dispatch('toast', message: 'About page saved', type: 'success');
    }

    public function render()
    {
        $page = Page::findBySlug('about');

        return view('livewire.admin.about-page', [
            'previewImage' => $page?->imageUrl(),
        ])->layout('layouts.admin', [
            'title' => 'About Us',
        ]);
    }
}
