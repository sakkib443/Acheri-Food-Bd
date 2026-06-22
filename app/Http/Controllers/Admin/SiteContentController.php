<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SiteContentController extends Controller
{
    /**
     * Logo & site name.
     */
    public function branding()
    {
        return view('admin.site-content.branding');
    }

    public function updateBranding(Request $request)
    {
        $request->validate([
            'site_name' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->filled('site_name')) {
            Setting::put('site_name', $request->input('site_name'));
        }

        if ($path = $this->storeImage($request, 'logo', 'logo')) {
            Setting::put('logo', $path);
        }

        return back()->with('success', __('Logo & name updated successfully.'));
    }

    /**
     * Hero banners (2).
     */
    public function hero()
    {
        return view('admin.site-content.hero');
    }

    public function updateHero(Request $request)
    {
        $request->validate([
            'hero_1' => ['nullable', 'image', 'max:4096'],
            'hero_1_link' => ['nullable', 'string', 'max:255'],
            'hero_2' => ['nullable', 'image', 'max:4096'],
            'hero_2_link' => ['nullable', 'string', 'max:255'],
        ]);

        Setting::put('hero_1_link', $request->input('hero_1_link') ?: '/products');
        Setting::put('hero_2_link', $request->input('hero_2_link') ?: '/products');

        if ($path = $this->storeImage($request, 'hero_1', 'hero-1')) {
            Setting::put('hero_1', $path);
        }
        if ($path = $this->storeImage($request, 'hero_2', 'hero-2')) {
            Setting::put('hero_2', $path);
        }

        return back()->with('success', __('Hero banners updated successfully.'));
    }

    /**
     * Move an uploaded image into public/images and return its relative path.
     */
    private function storeImage(Request $request, string $field, string $prefix): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        $file = $request->file($field);
        $dir = public_path('images');

        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = $prefix.'-'.time().'.'.$file->getClientOriginalExtension();
        $file->move($dir, $filename);

        return 'images/'.$filename;
    }
}
