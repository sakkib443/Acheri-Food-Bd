<?php

/**
 * One-off generator for product placeholder images.
 * Run:  php database/gen-product-placeholders.php
 * Replace the generated SVGs with real product photos any time
 * (keep the same filename, or update the `image` column in the seeder).
 */

$dir = __DIR__ . '/../public/images/products';

if (! is_dir($dir)) {
    mkdir($dir, 0755, true);
}

$products = [
    'mustard-oil'       => ['🛢️', 'Mustard Oil 5L'],
    'sundarban-honey'   => ['🍯', 'Sundarban Honey'],
    'gawa-ghee'         => ['🧈', 'Gawa Ghee 1kg'],
    'black-seed-honey'  => ['🍯', 'Black Seed Honey'],
    'ajwa-dates'        => ['🌴', 'Ajwa Dates'],
    'black-seed'        => ['⚫', 'Black Seed'],
    'cashew-nuts'       => ['🥜', 'Cashew Nuts'],
    'mango-pickle'      => ['🥭', 'Mango Pickle'],
    'chinigura-rice'    => ['🍚', 'Chinigura Rice'],
    'red-lentil'        => ['🫘', 'Red Lentil'],
];

foreach ($products as $slug => [$emoji, $label]) {
    $label = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');

    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300" width="300" height="300">
  <title>{$label}</title>
  <text x="150" y="150" font-size="200" text-anchor="middle" dominant-baseline="central">{$emoji}</text>
</svg>

SVG;

    file_put_contents("{$dir}/{$slug}.svg", $svg);
    echo "created {$slug}.svg\n";
}

echo "Done. " . count($products) . " placeholders written to public/images/products\n";
