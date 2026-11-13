<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [
            ['loc' => url('/'), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => route('shop'), 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => route('about'), 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => route('contact'), 'changefreq' => 'monthly', 'priority' => '0.6'],
        ];

        if (Schema::hasTable('products')) {
            Product::query()
                ->active()
                ->whereNotNull('slug')
                ->where('slug', '!=', '')
                ->orderByDesc('updated_at')
                ->get(['slug', 'updated_at'])
                ->each(function (Product $product) use (&$urls) {
                    $urls[] = [
                        'loc' => route('product.show', $product->slug),
                        'lastmod' => optional($product->updated_at)?->toAtomString(),
                        'changefreq' => 'weekly',
                        'priority' => '0.8',
                    ];
                });
        }

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
