<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Seed the categories shown in the header, the home "Featured Categories"
     * section and the shop sidebar — all from this single source.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Mango Pickle',      'emoji' => '🥭'],
            ['name' => 'Beef Tripe',        'emoji' => '🍖'],
            ['name' => 'Garlic Pickle',     'emoji' => '🧄'],
            ['name' => 'Olive Pickle',      'emoji' => '🫒'],
            ['name' => 'Jujube Pickle',     'emoji' => '🍑'],
            ['name' => 'Chili Pickle',      'emoji' => '🌶️'],
            ['name' => 'Chicken Pickle',    'emoji' => '🍗'],
            ['name' => 'Mixed Pickle',      'emoji' => '🫙'],
            ['name' => 'Tamarind Pickle',   'emoji' => '🟤'],
            ['name' => 'Dried Fish Pickle', 'emoji' => '🐟'],
        ];

        foreach (array_values($categories) as $index => $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'emoji' => $category['emoji'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
