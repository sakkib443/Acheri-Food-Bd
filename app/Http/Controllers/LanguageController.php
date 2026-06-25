<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Switch the active storefront language and return to the previous page.
     *
     * Kept as a controller action (not a route closure) so that
     * `php artisan route:cache` / `optimize` works on the server.
     */
    public function __invoke(Request $request, string $locale)
    {
        if (in_array($locale, ['en', 'bn'], true)) {
            session(['locale' => $locale]);
        }

        return back();
    }
}
