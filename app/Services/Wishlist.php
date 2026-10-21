<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class Wishlist
{
    public const SESSION_KEY = 'wishlist.items';

    public static function items(): array
    {
        return array_values(Session::get(self::SESSION_KEY, []));
    }

    public static function count(): int
    {
        return count(Session::get(self::SESSION_KEY, []));
    }

    public static function has(int $productId): bool
    {
        return isset(Session::get(self::SESSION_KEY, [])[$productId]);
    }

    /** @return bool true when added, false when removed */
    public static function toggle(Product $product): bool
    {
        if (self::has($product->id)) {
            self::remove($product->id);

            return false;
        }

        self::add($product);

        return true;
    }

    public static function add(Product $product): void
    {
        $items = Session::get(self::SESSION_KEY, []);

        $items[$product->id] = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => (float) $product->salePrice(),
            'image' => $product->imageUrl(),
        ];

        Session::put(self::SESSION_KEY, $items);
    }

    public static function remove(int $productId): void
    {
        $items = Session::get(self::SESSION_KEY, []);
        unset($items[$productId]);
        Session::put(self::SESSION_KEY, $items);
    }

    public static function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public static function isEmpty(): bool
    {
        return self::items() === [];
    }
}
