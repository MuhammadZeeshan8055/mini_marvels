<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Support\MediaUrl;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $footer = SiteSetting::footerDefaults();

            if (Schema::hasTable('site_settings')) {
                $footer = array_merge($footer, SiteSetting::getValue('footer', []));
            }

            $footer['newsletter_image'] = MediaUrl::resolve(
                $footer['newsletter_image'] ?? null,
                'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=240&h=240&fit=crop'
            );

            $footer['gallery_images'] = array_values(array_map(
                fn ($url) => MediaUrl::resolve((string) $url),
                $footer['gallery_images'] ?? []
            ));

            $view->with('footerSettings', $footer);
        });
    }
}
