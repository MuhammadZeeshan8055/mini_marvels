<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LocalCatalogSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@minimarvels.test'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'is_admin' => true,
            ]
        );

        $path = database_path('data/catalog.json');

        if (! File::exists($path)) {
            $this->command?->error('Missing catalog file: '.$path);

            return;
        }

        $payload = json_decode(File::get($path), true);

        if (! is_array($payload)) {
            $this->command?->error('Catalog file is invalid JSON.');

            return;
        }

        DB::transaction(function () use ($payload) {
            ProductImage::query()->delete();
            Product::query()->delete();
            Category::query()->delete();

            $categories = [];

            foreach (($payload['categories'] ?? []) as $item) {
                $slug = $item['slug'] ?? Str::slug($item['name'] ?? 'category');
                $categories[$slug] = Category::create([
                    'name' => $item['name'],
                    'slug' => $slug,
                    'emoji' => $item['emoji'] ?? null,
                ]);
            }

            foreach (($payload['products'] ?? []) as $item) {
                $categorySlug = $item['category_slug'] ?? null;
                $category = $categorySlug && isset($categories[$categorySlug])
                    ? $categories[$categorySlug]
                    : ($categories[array_key_first($categories)] ?? null);

                if (! $category) {
                    continue;
                }

                $product = Product::create([
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'slug' => $item['slug'] ?? Str::slug($item['name']),
                    'description' => $item['description'] ?? null,
                    'meta_title' => $item['meta_title'] ?? null,
                    'meta_description' => $item['meta_description'] ?? null,
                    'meta_keywords' => $item['meta_keywords'] ?? null,
                    'price' => $item['price'] ?? 0,
                    'official_price' => $item['official_price'] ?? null,
                    'image' => $item['image'] ?? null,
                    'age' => $item['age'] ?? '3-8 Years',
                    'stock' => $item['stock'] ?? 25,
                    'is_featured' => (bool) ($item['is_featured'] ?? false),
                    'is_active' => (bool) ($item['is_active'] ?? true),
                ]);

                foreach (($item['images'] ?? []) as $image) {
                    if (empty($image['path'])) {
                        continue;
                    }

                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $image['path'],
                        'color_name' => $image['color_name'] ?? null,
                        'color_hex' => $image['color_hex'] ?? null,
                        'sort_order' => $image['sort_order'] ?? 0,
                    ]);
                }
            }
        });

        $this->command?->info(
            'Seeded '.Product::count().' products, '.Category::count().' categories, '.ProductImage::count().' images.'
        );
    }
}
