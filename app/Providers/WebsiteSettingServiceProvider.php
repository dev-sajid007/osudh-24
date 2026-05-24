<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Schema;

class WebsiteSettingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share website settings safely (no crash if table missing)
        View::composer(['layouts.frontend.*', 'frontend.*'], function ($view) {

            $websiteSettings = [];

            // 🔒 safety check: table exists or not
            if (Schema::hasTable('website_settings')) {
                try {
                    $websiteSettings = WebsiteSetting::getAllSettings();
                } catch (\Exception $e) {
                    $websiteSettings = [];
                }
            }

            $view->with('settings', $websiteSettings);
        });

        // Blade helper function
        if (!function_exists('setting')) {
            function setting($key, $default = null)
            {
                try {
                    return WebsiteSetting::get($key, $default);
                } catch (\Exception $e) {
                    return $default;
                }
            }
        }
    }
}