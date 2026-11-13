<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'array',
        ];
    }

    public static function getValue(string $key, array $default = []): array
    {
        try {
            return Cache::remember("site_setting.{$key}", 60, function () use ($key, $default) {
                $setting = static::query()->where('key', $key)->first();
                $value = $setting?->value;

                return is_array($value) ? $value : $default;
            });
        } catch (\Throwable) {
            return $default;
        }
    }

    public static function putValue(string $key, array $value): void
    {
        static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("site_setting.{$key}");
    }

    public static function footerDefaults(): array
    {
        return [
            'gallery_title' => '@Mini Marvels',
            'address' => 'Murree Road, Rawalpindi',
            'phone' => '03325777194',
            'email' => 'minimarvels804@gmail.com',
            'newsletter_text' => 'Join our list and get 15% off your first purchase!',
            'newsletter_image' => 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=240&h=240&fit=crop',
            'copyright' => 'Mini Marvels. All Rights Reserved.',
            'gallery_images' => [
                'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=300&h=300&fit=crop',
                'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?w=300&h=300&fit=crop',
            ],
            'social_links' => static::defaultSocialLinks(),
        ];
    }

    /**
     * @return array<int, array{platform: string, url: string}>
     */
    public static function defaultSocialLinks(): array
    {
        $configured = config('seo.social', []);

        $platforms = ['facebook', 'instagram', 'youtube', 'twitter', 'linkedin', 'tiktok'];
        $links = [];

        foreach ($platforms as $platform) {
            $url = trim((string) ($configured[$platform] ?? ''));

            if ($url === '' || $url === '#') {
                continue;
            }

            $links[] = [
                'platform' => $platform,
                'url' => $url,
            ];
        }

        return $links;
    }

    /**
     * Absolute http(s) social links for the storefront / schema sameAs.
     *
     * @return array<int, array{platform: string, url: string, label: string}>
     */
    public static function resolvedSocialLinks(?array $footer = null): array
    {
        try {
            if ($footer === null) {
                $footer = static::footerDefaults();
            }

            $links = $footer['social_links'] ?? [];

            if (! is_array($links) || $links === []) {
                $links = static::defaultSocialLinks();
            }

            $resolved = [];

            foreach ($links as $link) {
                if (! is_array($link)) {
                    continue;
                }

                $platform = strtolower(trim((string) ($link['platform'] ?? '')));
                $url = trim((string) ($link['url'] ?? ''));

                if ($url === '' || $url === '#') {
                    $url = trim((string) config("seo.social.{$platform}", ''));
                }

                if ($platform === '' || (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://'))) {
                    continue;
                }

                $resolved[] = [
                    'platform' => $platform,
                    'url' => $url,
                    'label' => match ($platform) {
                        'twitter' => 'X',
                        'youtube' => 'YouTube',
                        'linkedin' => 'LinkedIn',
                        'tiktok' => 'TikTok',
                        default => ucfirst($platform),
                    },
                ];
            }

            return array_values($resolved);
        } catch (\Throwable) {
            return static::defaultSocialLinks();
        }
    }

    public static function testimonialIntroDefaults(): array
    {
        return [
            'kicker' => 'Top Reviews',
            'title' => 'Client Testimonials',
            'description' => 'Hear from families and teachers who make Mini Marvels part of every playful day.',
        ];
    }
}
