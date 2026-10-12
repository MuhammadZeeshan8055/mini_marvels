<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DownloadProductImages extends Command
{
    protected $signature = 'products:download-images
                            {--force : Re-download even if local file already exists}';

    protected $description = 'Download remote product/gallery images into storage/app/public/products';

    public function handle(): int
    {
        $force = (bool) $this->option('force');
        $disk = Storage::disk('public');
        $downloaded = 0;
        $skipped = 0;
        $failed = 0;

        $products = Product::query()->orderBy('id')->get();
        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        foreach ($products as $product) {
            $folder = 'products/'.$product->id;

            if (is_string($product->image) && str_starts_with($product->image, 'http')) {
                $local = $this->downloadTo($disk, $product->image, $folder.'/cover', $force);
                if ($local) {
                    $product->update(['image' => $local]);
                    $downloaded++;
                } elseif ($local === false) {
                    $failed++;
                } else {
                    $skipped++;
                }
            }

            $images = ProductImage::query()
                ->where('product_id', $product->id)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();

            foreach ($images as $index => $image) {
                if (! is_string($image->path) || ! str_starts_with($image->path, 'http')) {
                    continue;
                }

                $local = $this->downloadTo($disk, $image->path, $folder.'/'.($index + 1), $force);
                if ($local) {
                    $image->update(['path' => $local]);
                    $downloaded++;

                    // Keep cover in sync with first gallery image when possible
                    if ($index === 0 && (! $product->image || str_starts_with((string) $product->image, 'http'))) {
                        $product->update(['image' => $local]);
                    }
                } elseif ($local === false) {
                    $failed++;
                } else {
                    $skipped++;
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Downloaded: {$downloaded}, skipped: {$skipped}, failed: {$failed}");

        return $failed > 0 && $downloaded === 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * @return string|null|false  local path on success, null if skipped, false on failure
     */
    private function downloadTo($disk, string $url, string $basePathWithoutExt, bool $force): string|false|null
    {
        $extension = $this->guessExtension($url);
        $relative = $basePathWithoutExt.'.'.$extension;

        if (! $force && $disk->exists($relative)) {
            return $relative;
        }

        try {
            $response = Http::timeout(45)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Referer' => 'https://www.daraz.pk/',
                    'Accept' => 'image/avif,image/webp,image/apng,image/*,*/*;q=0.8',
                ])
                ->get($url);

            if (! $response->successful()) {
                $this->warn("HTTP {$response->status()} for {$url}");

                return false;
            }

            $body = $response->body();
            if ($body === '' || strlen($body) < 100) {
                $this->warn("Empty body for {$url}");

                return false;
            }

            // Detect real image type from bytes when possible
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->buffer($body) ?: '';
            $extension = match (true) {
                str_contains($mime, 'jpeg') => 'jpg',
                str_contains($mime, 'png') => 'png',
                str_contains($mime, 'webp') => 'webp',
                str_contains($mime, 'gif') => 'gif',
                default => $extension,
            };
            $relative = $basePathWithoutExt.'.'.$extension;

            $disk->put($relative, $body);

            return $relative;
        } catch (\Throwable $e) {
            $this->warn("Fail {$url}: ".$e->getMessage());

            return false;
        }
    }

    private function guessExtension(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH) ?: '';
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)
            ? ($ext === 'jpeg' ? 'jpg' : $ext)
            : 'jpg';
    }
}
