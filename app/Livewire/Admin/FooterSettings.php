<?php

namespace App\Livewire\Admin;

use App\Models\SiteSetting;
use App\Support\MediaUrl;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FooterSettings extends Component
{
    use WithFileUploads;

    public string $gallery_title = '';

    public string $address = '';

    public string $phone = '';

    public string $email = '';

    public string $newsletter_text = '';

    public string $newsletter_image_url = '';

    public $newsletter_image_upload = null;

    public string $copyright = '';

    /** @var array<int, string> */
    public array $gallery_images = [];

    /** @var array<int, array{platform:string,url:string}> */
    public array $social_links = [];

    public function mount(): void
    {
        $footer = array_merge(
            SiteSetting::footerDefaults(),
            SiteSetting::getValue('footer', [])
        );

        $this->gallery_title = (string) ($footer['gallery_title'] ?? '');
        $this->address = (string) ($footer['address'] ?? '');
        $this->phone = (string) ($footer['phone'] ?? '');
        $this->email = (string) ($footer['email'] ?? '');
        $this->newsletter_text = (string) ($footer['newsletter_text'] ?? '');
        $this->copyright = (string) ($footer['copyright'] ?? '');

        $newsletterImage = (string) ($footer['newsletter_image'] ?? '');
        $this->newsletter_image_url = str_starts_with($newsletterImage, 'http')
            ? $newsletterImage
            : '';

        $this->gallery_images = array_values(array_map(
            fn ($url) => (string) $url,
            $footer['gallery_images'] ?? []
        ));

        while (count($this->gallery_images) < 6) {
            $this->gallery_images[] = '';
        }

        $this->gallery_images = array_slice($this->gallery_images, 0, 6);

        $links = $footer['social_links'] ?? [];
        $this->social_links = [];

        foreach ($links as $link) {
            $this->social_links[] = [
                'platform' => (string) ($link['platform'] ?? 'facebook'),
                'url' => (string) ($link['url'] ?? ''),
            ];
        }

        if ($this->social_links === []) {
            $this->social_links = [
                ['platform' => 'facebook', 'url' => ''],
                ['platform' => 'instagram', 'url' => ''],
            ];
        }
    }

    public function addSocialLink(): void
    {
        $this->social_links[] = ['platform' => 'instagram', 'url' => ''];
    }

    public function removeSocialLink(int $index): void
    {
        unset($this->social_links[$index]);
        $this->social_links = array_values($this->social_links);
    }

    public function save(): void
    {
        $this->validate([
            'gallery_title' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:150'],
            'newsletter_text' => ['nullable', 'string', 'max:255'],
            'newsletter_image_url' => ['nullable', 'string', 'max:500'],
            'newsletter_image_upload' => ['nullable', 'image', 'max:4096'],
            'copyright' => ['required', 'string', 'max:255'],
            'gallery_images' => ['array', 'max:6'],
            'gallery_images.*' => ['nullable', 'string', 'max:500'],
            'social_links' => ['array'],
            'social_links.*.platform' => ['required', 'string', 'max:40'],
            'social_links.*.url' => ['nullable', 'string', 'max:500'],
        ]);

        $existing = SiteSetting::getValue('footer', SiteSetting::footerDefaults());
        $newsletterImage = $existing['newsletter_image'] ?? null;

        if ($this->newsletter_image_upload) {
            if (is_string($newsletterImage) && $newsletterImage !== '' && ! str_starts_with($newsletterImage, 'http')) {
                Storage::disk('public')->delete($newsletterImage);
            }

            $newsletterImage = $this->newsletter_image_upload->store('footer', 'public');
            $this->newsletter_image_upload = null;
        } elseif ($this->newsletter_image_url !== '' && str_starts_with($this->newsletter_image_url, 'http')) {
            $newsletterImage = $this->newsletter_image_url;
        }

        SiteSetting::putValue('footer', [
            'gallery_title' => $this->gallery_title,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'newsletter_text' => $this->newsletter_text,
            'newsletter_image' => $newsletterImage,
            'copyright' => $this->copyright,
            'gallery_images' => array_values(array_filter(
                array_map('trim', $this->gallery_images),
                fn ($url) => $url !== ''
            )),
            'social_links' => array_values(array_map(
                fn ($link) => [
                    'platform' => strtolower(trim($link['platform'])),
                    'url' => trim((string) ($link['url'] ?? '')),
                ],
                $this->social_links
            )),
        ]);

        $this->dispatch('toast', message: 'Footer settings saved', type: 'success');
    }

    public function render()
    {
        $footer = SiteSetting::getValue('footer', SiteSetting::footerDefaults());
        $newsletterPreview = MediaUrl::resolve(
            $footer['newsletter_image'] ?? null,
            'https://placehold.co/120x120/FFE8F0/5D3E9F?text=Art'
        );

        return view('livewire.admin.footer-settings', [
            'platforms' => ['facebook', 'tiktok', 'instagram', 'youtube', 'twitter', 'linkedin'],
            'newsletterPreview' => $newsletterPreview,
        ])->layout('layouts.admin', [
            'title' => 'Footer',
        ]);
    }
}
