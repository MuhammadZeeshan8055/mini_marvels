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
        return Cache::remember("site_setting.{$key}", 60, function () use ($key, $default) {
            $setting = static::query()->where('key', $key)->first();

            return $setting?->value ?? $default;
        });
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
            'address' => 'No: 58 A, East Madison Street, Baltimore, MD, USA 4508',
            'phone' => '+00 (0) 123 456 789',
            'email' => 'contact@example.com',
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
            'social_links' => [
                ['platform' => 'facebook', 'url' => '#'],
                ['platform' => 'tiktok', 'url' => '#'],
                ['platform' => 'instagram', 'url' => '#'],
                ['platform' => 'youtube', 'url' => '#'],
            ],
        ];
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
