<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
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
        // Let database-saved settings override the config/site.php defaults.
        $this->loadSiteSettings();

        // Share the active categories with the header, home page and shop —
        // a single database-driven source for the whole site's navigation.
        View::composer(['components.site-header', 'home', 'products.index'], function ($view) {
            $view->with('navCategories', Category::active()->ordered()->get());
        });
    }

    /**
     * Override config('site.*') with values saved in the settings table.
     */
    private function loadSiteSettings(): void
    {
        try {
            if (! Schema::hasTable('settings')) {
                return;
            }

            $values = Setting::allValues();
        } catch (\Throwable) {
            return;
        }

        $scalars = [
            'whatsapp' => 'site.whatsapp',
            'phone' => 'site.phone',
            'email' => 'site.email',
            'address' => 'site.address',
            'facebook' => 'site.social.facebook',
            'instagram' => 'site.social.instagram',
            'youtube' => 'site.social.youtube',
        ];

        foreach ($scalars as $key => $cfg) {
            if (isset($values[$key]) && $values[$key] !== '' && $values[$key] !== null) {
                config([$cfg => $values[$key]]);
            }
        }

        if (! empty($values['delivery_charge'])) {
            config(['site.delivery_charge' => (int) $values['delivery_charge']]);
        }

        if (! empty($values['whatsapp'])) {
            config(['site.social.whatsapp' => 'https://wa.me/'.$values['whatsapp']]);
        }
    }
}
