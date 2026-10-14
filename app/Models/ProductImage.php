<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'path',
        'color_name',
        'color_hex',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function url(): string
    {
        if (str_starts_with($this->path, 'http://') || str_starts_with($this->path, 'https://')) {
            return $this->path;
        }

        // Root-relative path (works on localhost / 127.0.0.1:8010 / any port)
        return '/storage/'.ltrim($this->path, '/');
    }

    /**
     * Always return a valid #RRGGBB for swatches (never empty / missing #).
     */
    public function swatchHex(): ?string
    {
        if (! filled($this->color_name) && ! filled($this->color_hex)) {
            return null;
        }

        return self::normalizeHex($this->color_hex, $this->color_name) ?? '#6b7280';
    }

    public static function normalizeHex(?string $hex, ?string $colorName = null): ?string
    {
        $hex = trim((string) $hex);

        if ($hex !== '') {
            if (! str_starts_with($hex, '#')) {
                $hex = '#'.$hex;
            }

            if (preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $hex)) {
                if (strlen($hex) === 4) {
                    $hex = sprintf(
                        '#%s%s%s%s%s%s',
                        $hex[1],
                        $hex[1],
                        $hex[2],
                        $hex[2],
                        $hex[3],
                        $hex[3]
                    );
                }

                return strtolower($hex);
            }
        }

        return self::hexFromColorName($colorName);
    }

    public static function hexFromColorName(?string $name): ?string
    {
        if (! filled($name)) {
            return null;
        }

        $key = strtolower(trim(preg_replace('/\s+/', ' ', $name)));

        $map = [
            'black' => '#111111',
            'white' => '#ffffff',
            'grey' => '#9ca3af',
            'gray' => '#9ca3af',
            'red' => '#dc2626',
            'blue' => '#2563eb',
            'green' => '#16a34a',
            'pink' => '#ec4899',
            'yellow' => '#eab308',
            'orange' => '#f97316',
            'purple' => '#7c3aed',
            'brown' => '#92400e',
            'beige' => '#d5b08a',
            'navy' => '#1e3a8a',
            'maroon' => '#7f1d1d',
            'gold' => '#d4a017',
            'silver' => '#c0c0c0',
        ];

        if (isset($map[$key])) {
            return $map[$key];
        }

        foreach ($map as $label => $value) {
            if (str_contains($key, $label)) {
                return $value;
            }
        }

        return null;
    }
}
