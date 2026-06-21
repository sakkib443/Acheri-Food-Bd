<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Seed the products table with the storefront catalogue.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Deshi Mustard Oil 5 Liter',
                'category' => 'Oil & Ghee',
                'description' => 'Cold-pressed pure deshi mustard oil (sorisha tel), 5 liter bottle.',
                'image' => 'images/products/mustard-oil.svg',
                'price' => 1550,
                'old_price' => null,
                'stock' => 120,
                'is_best_selling' => true,
                'is_top_selling' => true,
            ],
            [
                'name' => 'Sundarban Natural Honey 1kg',
                'category' => 'Honey',
                'description' => 'Raw natural honey collected from the Sundarban forest, 1kg jar.',
                'image' => 'images/products/sundarban-honey.svg',
                'price' => 2300,
                'old_price' => 2500,
                'stock' => 80,
                'is_best_selling' => false,
                'is_top_selling' => true,
            ],
            [
                'name' => 'Gawa Ghee 1kg',
                'category' => 'Oil & Ghee',
                'description' => 'Traditional hand-made gawa ghee from pure cow milk, 1kg tin.',
                'image' => 'images/products/gawa-ghee.svg',
                'price' => 1800,
                'old_price' => null,
                'stock' => 60,
                'is_best_selling' => true,
                'is_top_selling' => true,
            ],
            [
                'name' => 'Black Seed Honey 1kg',
                'category' => 'Honey',
                'description' => 'Kalo jira (black seed) flower honey, 1kg jar.',
                'image' => 'images/products/black-seed-honey.svg',
                'price' => 1500,
                'old_price' => 1600,
                'stock' => 95,
                'is_best_selling' => false,
                'is_top_selling' => true,
            ],
            [
                'name' => 'Premium Ajwa Dates 1kg',
                'category' => 'Dates',
                'description' => 'Soft premium Ajwa dates imported from Madinah, 1kg box.',
                'image' => 'images/products/ajwa-dates.svg',
                'price' => 1200,
                'old_price' => 1400,
                'stock' => 150,
                'is_best_selling' => true,
                'is_top_selling' => false,
            ],
            [
                'name' => 'Kalo Jira Black Seed 500g',
                'category' => 'Spices',
                'description' => 'Pure black seed (kalo jira), naturally cleaned, 500g pack.',
                'image' => 'images/products/black-seed.svg',
                'price' => 450,
                'old_price' => null,
                'stock' => 200,
                'is_best_selling' => false,
                'is_top_selling' => false,
            ],
            [
                'name' => 'Premium Cashew Nuts 500g',
                'category' => 'Nuts & Seeds',
                'description' => 'Whole roasted premium cashew nuts (kaju badam), 500g pack.',
                'image' => 'images/products/cashew-nuts.svg',
                'price' => 850,
                'old_price' => 950,
                'stock' => 110,
                'is_best_selling' => false,
                'is_top_selling' => false,
            ],
            [
                'name' => 'Mango Pickle (Aam Achar) 1kg',
                'category' => 'Pickle',
                'description' => 'Homemade sun-dried mango pickle with traditional spices, 1kg jar.',
                'image' => 'images/products/mango-pickle.svg',
                'price' => 550,
                'old_price' => 650,
                'stock' => 130,
                'is_best_selling' => true,
                'is_top_selling' => false,
            ],
            [
                'name' => 'Chinigura Aromatic Rice 5kg',
                'category' => 'Rice',
                'description' => 'Fragrant Chinigura polao rice, premium grade, 5kg bag.',
                'image' => 'images/products/chinigura-rice.svg',
                'price' => 750,
                'old_price' => 800,
                'stock' => 90,
                'is_best_selling' => false,
                'is_top_selling' => false,
            ],
            [
                'name' => 'Red Lentil (Mosur Dal) 1kg',
                'category' => 'Flours & Lentils',
                'description' => 'Premium cleaned red lentil (deshi mosur dal), 1kg pack.',
                'image' => 'images/products/red-lentil.svg',
                'price' => 140,
                'old_price' => null,
                'stock' => 300,
                'is_best_selling' => false,
                'is_top_selling' => false,
            ],
        ];

        foreach (array_values($products) as $index => $product) {
            $product['slug'] = Str::slug($product['name']);
            $product['sort_order'] = $index + 1;

            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }
    }
}
