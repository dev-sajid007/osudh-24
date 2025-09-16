<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\WebsiteSetting;

class WebsiteSettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share website settings with frontend views only
        View::composer(['layouts.frontend.*', 'frontend.*'], function ($view) {
            $websiteSettings = WebsiteSetting::getAllSettings();
            $view->with('settings', $websiteSettings);
        });

        // Create a helper function for blade templates
        if (!function_exists('setting')) {
            function setting($key, $default = null)
            {
                return WebsiteSetting::get($key, $default);
            }
        }
    }
}
