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

        // Site name (brand) — overrides the app name everywhere.
        if (! empty($values['site_name'])) {
            config(['app.name' => $values['site_name'], 'site.name' => $values['site_name']]);
        }

        // Logo uploaded from the admin panel.
        if (! empty($values['logo'])) {
            config(['site.logo' => $values['logo']]);
        }

        // Hero banners uploaded from the admin panel — override each slot
        // independently, keeping the config defaults for anything not set.
        $hero = config('site.hero');
        if (! empty($values['hero_1'])) {
            $hero[0]['image'] = $values['hero_1'];
        }
        if (! empty($values['hero_1_link'])) {
            $hero[0]['link'] = $values['hero_1_link'];
        }
        if (! empty($values['hero_2'])) {
            $hero[1]['image'] = $values['hero_2'];
        }
        if (! empty($values['hero_2_link'])) {
            $hero[1]['link'] = $values['hero_2_link'];
        }
        config(['site.hero' => $hero]);
    }
}
