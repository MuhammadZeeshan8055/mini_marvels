<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'content',
        'image',
        'meta_title',
        'meta_description',
        'extras',
    ];

    protected function casts(): array
    {
        return [
            'extras' => 'array',
        ];
    }

    public static function findBySlug(string $slug): ?self
    {
        return static::query()->where('slug', $slug)->first();
    }

    public function imageUrl(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return MediaUrl::resolve($this->image);
    }

    public function extra(string $key, mixed $default = null): mixed
    {
        return data_get($this->extras ?? [], $key, $default);
    }
}
