<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'eyebrow',
        'title',
        'text',
        'button_label',
        'button_url',
        'image',
        'title_dark',
        'eyebrow_box',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'title_dark' => 'boolean',
            'eyebrow_box' => 'boolean',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function imageUrl(): string
    {
        return MediaUrl::resolve(
            $this->image,
            'https://placehold.co/900x900/5D3E9F/FFFFFF?text=Hero'
        );
    }

    public function toFrontend(): array
    {
        return [
            'eyebrow' => $this->eyebrow ?? '',
            'title' => $this->title,
            'text' => $this->text ?? '',
            'button_label' => $this->button_label ?: 'Shop Now',
            'button_url' => $this->button_url ?: '#products',
            'image' => $this->imageUrl(),
            'title_dark' => $this->title_dark,
            'eyebrow_box' => $this->eyebrow_box,
        ];
    }
}
