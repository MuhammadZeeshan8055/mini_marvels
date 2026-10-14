<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Cart
{
    public const SESSION_KEY = 'cart.items';

    public const COUPON_KEY = 'cart.coupon';

    public static function items(): array
    {
        $items = Session::get(self::SESSION_KEY, []);
        $normalized = [];

        foreach ($items as $sessionKey => $item) {
            $item['key'] = $item['key'] ?? (string) $sessionKey;
            $item['color'] = $item['color'] ?? null;
            $normalized[] = $item;
        }

        return $normalized;
    }

    public static function count(): int
    {
        return collect(self::items())->sum('quantity');
    }

    public static function subtotal(): float
    {
        return round((float) collect(self::items())->sum(
            fn (array $item) => $item['price'] * $item['quantity']
        ), 2);
    }

    public static function coupon(): ?string
    {
        return Session::get(self::COUPON_KEY);
    }

    public static function discount(): float
    {
        if (self::coupon() !== 'CUTIE10') {
            return 0;
        }

        return round(self::subtotal() * 0.1, 2);
    }

    public static function total(): float
    {
        return max(0, self::subtotal() - self::discount());
    }

    /**
     * @param  array{name?: ?string, image?: ?string, hex?: ?string}|null  $variant
     */
    public static function add(Product $product, int $quantity = 1, ?array $variant = null): void
    {
        $quantity = max(1, $quantity);
        $items = Session::get(self::SESSION_KEY, []);

        $color = filled($variant['name'] ?? null) ? (string) $variant['name'] : null;
        $image = filled($variant['image'] ?? null) ? (string) $variant['image'] : $product->imageUrl();
        $key = self::lineKey($product->id, $color);

        if (isset($items[$key])) {
            $items[$key]['quantity'] += $quantity;
            $items[$key]['image'] = $image;
            if ($color) {
                $items[$key]['color'] = $color;
            }
        } else {
            $items[$key] = [
                'key' => $key,
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => (float) $product->salePrice(),
                'quantity' => $quantity,
                'image' => $image,
                'color' => $color,
            ];
        }

        if ($product->stock > 0) {
            $otherQty = collect($items)
                ->filter(fn (array $item, string $itemKey) => $itemKey !== $key && (int) $item['id'] === $product->id)
                ->sum('quantity');

            $maxForLine = max(0, $product->stock - (int) $otherQty);
            $items[$key]['quantity'] = min($items[$key]['quantity'], $maxForLine);

            if ($items[$key]['quantity'] < 1) {
                unset($items[$key]);
            }
        }

        Session::put(self::SESSION_KEY, $items);
    }

    public static function updateQuantity(string $key, int $quantity): void
    {
        $items = Session::get(self::SESSION_KEY, []);

        if (! isset($items[$key])) {
            return;
        }

        if ($quantity < 1) {
            unset($items[$key]);
            Session::put(self::SESSION_KEY, $items);

            return;
        }

        $productId = (int) $items[$key]['id'];
        $product = Product::query()->find($productId);

        if ($product && $product->stock > 0) {
            $otherQty = collect($items)
                ->filter(fn (array $item, string $itemKey) => $itemKey !== $key && (int) $item['id'] === $productId)
                ->sum('quantity');

            $quantity = min($quantity, max(0, $product->stock - (int) $otherQty));
        }

        if ($quantity < 1) {
            unset($items[$key]);
        } else {
            $items[$key]['quantity'] = $quantity;
        }

        Session::put(self::SESSION_KEY, $items);
    }

    public static function remove(string $key): void
    {
        $items = Session::get(self::SESSION_KEY, []);
        unset($items[$key]);
        Session::put(self::SESSION_KEY, $items);
    }

    public static function applyCoupon(string $code): bool
    {
        $code = strtoupper(trim($code));

        if ($code === 'CUTIE10') {
            Session::put(self::COUPON_KEY, $code);

            return true;
        }

        Session::forget(self::COUPON_KEY);

        return false;
    }

    public static function clear(): void
    {
        Session::forget(self::SESSION_KEY);
        Session::forget(self::COUPON_KEY);
    }

    public static function isEmpty(): bool
    {
        return self::items() === [];
    }

    public static function lineKey(int $productId, ?string $color): string
    {
        if (! filled($color)) {
            return (string) $productId;
        }

        return $productId.':'.Str::slug($color);
    }
}
