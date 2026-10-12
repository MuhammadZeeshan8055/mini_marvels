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

class DarazCatalogSeeder extends Seeder
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

        $path = storage_path('app/imports/daraz_toys_corner.json');

        if (! File::exists($path)) {
            $this->command?->error('Missing import file: '.$path);

            return;
        }

        $items = json_decode(File::get($path), true);

        if (! is_array($items) || $items === []) {
            $this->command?->error('Import file is empty or invalid.');

            return;
        }

        DB::transaction(function () use ($items) {
            ProductImage::query()->delete();
            Product::query()->delete();
            Category::query()->delete();

            $categoryData = [
                ['name' => 'RC Vehicles', 'emoji' => '📡', 'keywords' => ['remote control', 'remote-control', 'r/c', ' rc ', 'rc car', 'rc vehicle']],
                ['name' => 'Die-Cast Cars', 'emoji' => '🚗', 'keywords' => ['diecast', 'die-cast', 'die cast', 'metal car', 'pull back', 'pullback', 'alloy', 'hummer', 'hilux', 'wrangler', 'model car']],
                ['name' => 'Outdoor Fun', 'emoji' => '🫧', 'keywords' => ['bubble', 'skipping', 'jumping', 'fishing', 'bounce', 'moon ball', 'blowgun', 'outdoor', 'fan', 'flashlight', 'lattoo', 'spinning top', 'lattu']],
                ['name' => 'Action Toys', 'emoji' => '🦸', 'keywords' => ['gun', 'superhero', 'spider-man', 'batman', 'superman', 'robot', 'dinosaur', 'transformer', 'money gun', 'fidget', 'spinner']],
                ['name' => 'Play Vehicles', 'emoji' => '🚚', 'keywords' => ['truck', 'train', 'plane', 'airplane', 'motorcycle', 'bike', 'tricycle', 'tuk tuk', 'dumper', 'excavator', 'crane', 'vehicle', 'car toy', 'stunt car', 'friction']],
                ['name' => 'Learning Toys', 'emoji' => '📚', 'keywords' => ['educational', 'learning', 'alphabet', 'laptop', 'tablet', 'islamic', 'phonetic', 'drawing pen', 'writing tablet', 'projector drawing', 'blocks', 'rubik', 'cube', 'puzzle']],
                ['name' => 'Pretend Play', 'emoji' => '🍳', 'keywords' => ['kitchen', 'cook', 'telephone', 'phone', 'microphone', 'karaoke', 'beads', 'craft', 'bracelet']],
                ['name' => 'Soft Toys', 'emoji' => '🧸', 'keywords' => ['plush', 'stuffed', 'bunny', 'puppy', 'elsa doll', 'rabbit', 'soft bunny', 'soft toy']],
            ];

            $categories = [];

            foreach ($categoryData as $item) {
                $categories[$item['name']] = Category::create([
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'emoji' => $item['emoji'],
                ]);
            }

            $fallback = Category::create([
                'name' => 'Kids Toys',
                'slug' => 'kids-toys',
                'emoji' => '🎁',
            ]);

            $featuredBudget = 12;
            $index = 0;

            foreach ($items as $item) {
                $name = trim((string) ($item['name'] ?? ''));
                $price = (float) ($item['price'] ?? 0);

                if ($name === '' || $price <= 0) {
                    continue;
                }

                $categoryName = $this->guessCategory($name, $categoryData) ?? 'Kids Toys';
                $category = $categories[$categoryName] ?? $fallback;
                $slug = $this->uniqueSlug($name, (string) ($item['daraz_id'] ?? $index));
                $official = isset($item['official_price']) && $item['official_price'] !== null
                    ? (float) $item['official_price']
                    : null;

                if ($official !== null && $official <= $price) {
                    $official = null;
                }

                $shortName = $this->shortenName($name);
                $description = $name.'. Quality kids toy from Toys Corner — available now at Mini Marvels.';

                $product = Product::create([
                    'category_id' => $category->id,
                    'name' => $shortName,
                    'slug' => $slug,
                    'description' => $description,
                    'meta_title' => $shortName.' | Mini Marvels',
                    'meta_description' => Str::limit($description, 155, ''),
                    'meta_keywords' => 'toys, kids toys, '.$category->name.', mini marvels',
                    'price' => $price,
                    'official_price' => $official,
                    'image' => $item['image'] ?? null,
                    'age' => $this->guessAge($name),
                    'stock' => random_int(8, 40),
                    'is_featured' => $index < $featuredBudget,
                    'is_active' => true,
                ]);

                if (! empty($item['image'])) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $item['image'],
                        'sort_order' => 0,
                    ]);
                }

                $index++;
            }

            // Drop unused fallback if nothing landed there... keep it if used
            if ($fallback->products()->count() === 0) {
                $fallback->delete();
            }
        });

        $this->command?->info('Imported '.Product::count().' products across '.Category::count().' categories.');
    }

    /**
     * @param  array<int, array{name: string, emoji: string, keywords: array<int, string>}>  $categoryData
     */
    private function guessCategory(string $name, array $categoryData): ?string
    {
        $haystack = ' '.Str::lower($name).' ';

        foreach ($categoryData as $item) {
            foreach ($item['keywords'] as $keyword) {
                if (str_contains($haystack, Str::lower($keyword))) {
                    return $item['name'];
                }
            }
        }

        return null;
    }

    private function shortenName(string $name): string
    {
        $name = preg_replace('/,?\s*(Learning Toys|Educational Toys|Funny Toys|Entertainment Toys|Puzzle Games|Newborn Toys|Toddler Toys).*$/i', '', $name) ?? $name;
        $name = trim($name, " \t\n\r\0\x0B,\"'");

        return Str::limit($name, 90, '');
    }

    private function uniqueSlug(string $name, string $suffix): string
    {
        $base = Str::slug(Str::limit($name, 60, ''));

        if ($base === '') {
            $base = 'toy';
        }

        return $base.'-'.$suffix;
    }

    private function guessAge(string $name): string
    {
        $lower = Str::lower($name);

        if (str_contains($lower, 'newborn') || str_contains($lower, 'infant') || preg_match('/\b(0|1|2)\s*year/', $lower)) {
            return '0-2 Years';
        }

        if (str_contains($lower, 'toddler') || str_contains($lower, '3+') || preg_match('/\b3\s*year/', $lower)) {
            return '3-4 Years';
        }

        if (str_contains($lower, 'remote') || str_contains($lower, 'rc ') || str_contains($lower, 'gun')) {
            return '5-7 Years';
        }

        return '3-8 Years';
    }
}
