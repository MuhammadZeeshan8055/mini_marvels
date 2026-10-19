<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'role',
        'text',
        'image',
        'rating',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
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
            'https://placehold.co/300x300/FFE8F0/5D3E9F?text=Review'
        );
    }

    public function toFrontend(): array
    {
        return [
            'name' => $this->name,
            'role' => $this->role ?? '',
            'text' => $this->text,
            'image' => $this->imageUrl(),
            'rating' => max(1, min(5, (int) $this->rating)),
        ];
    }
}
