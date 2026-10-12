<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'age',
        'stock',
        'is_featured',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function imageUrl(): string
    {
        if (! $this->image) {
            return 'https://placehold.co/400x400/FFE8F0/5D3E9F?text=Toy';
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        // Root-relative path (works on localhost / 127.0.0.1:8010 / any port)
        return '/storage/'.ltrim($this->image, '/');
    }

    /**
     * List of gallery images for cards / product page.
     * Main display image comes first.
     */
    public function colorVariants(): array
    {
        $images = $this->relationLoaded('images')
            ? $this->images
            : $this->images()->get();

        // No gallery yet — use cover image only
        if ($images->isEmpty()) {
            return [
                [
                    'name' => 'Original',
                    'hex' => '#d5b08a',
                    'image' => $this->imageUrl(),
                ],
            ];
        }

        $list = [];

        foreach ($images as $image) {
            $list[] = [
                'name' => $image->color_name ?: 'Color',
                'hex' => $image->color_hex ?: '#d5b08a',
                'image' => $image->url(),
                'is_main' => $this->image === $image->path,
            ];
        }

        // Put main image at the start
        usort($list, function ($a, $b) {
            if ($a['is_main'] === $b['is_main']) {
                return 0;
            }

            return $a['is_main'] ? -1 : 1;
        });

        // Remove helper key before return
        foreach ($list as $i => $item) {
            unset($list[$i]['is_main']);
            if ($list[$i]['name'] === 'Color') {
                $list[$i]['name'] = 'Color '.($i + 1);
            }
        }

        return array_values($list);
    }
}
