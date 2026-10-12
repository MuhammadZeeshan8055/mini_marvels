<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportDarazGalleries extends Command
{
    protected $signature = 'products:import-daraz-galleries
                            {--file= : Path to galleries JSON (default: storage/app/imports/daraz_galleries.json)}';

    protected $description = 'Attach multi-image galleries from Daraz scrape JSON to products';

    public function handle(): int
    {
        $path = $this->option('file') ?: storage_path('app/imports/daraz_galleries.json');

        if (! File::exists($path)) {
            $this->error('Missing gallery file: '.$path);

            return self::FAILURE;
        }

        $galleries = json_decode(File::get($path), true);

        if (! is_array($galleries) || $galleries === []) {
            $this->error('Gallery file is empty or invalid.');

            return self::FAILURE;
        }

        $updated = 0;
        $imagesAdded = 0;
        $skipped = 0;

        foreach ($galleries as $darazId => $urls) {
            $urls = array_values(array_unique(array_filter((array) $urls)));

            if ($urls === []) {
                $skipped++;

                continue;
            }

            $product = Product::query()
                ->where('slug', 'like', '%-'.$darazId)
                ->orWhere('image', 'like', '%'.$darazId.'%')
                ->first();

            if (! $product) {
                // Match by cover image filename fragment from first URL
                $needle = basename(parse_url($urls[0], PHP_URL_PATH) ?: '');
                $product = $needle
                    ? Product::query()->where('image', 'like', '%'.$needle)->first()
                    : null;
            }

            if (! $product) {
                $this->warn("No product for Daraz ID {$darazId}");
                $skipped++;

                continue;
            }

            $product->images()->delete();

            foreach ($urls as $index => $url) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $url,
                    'sort_order' => $index,
                ]);
                $imagesAdded++;
            }

            $product->update([
                'image' => $urls[0],
            ]);

            $updated++;
        }

        $this->info("Updated {$updated} products with {$imagesAdded} gallery images ({$skipped} skipped).");

        return self::SUCCESS;
    }
}
