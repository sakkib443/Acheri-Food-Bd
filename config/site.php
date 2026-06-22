<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Storefront settings
    |--------------------------------------------------------------------------
    | Central place for contact details, social links, delivery charge and the
    | home hero banners. Override any value via the matching .env key.
    */

    'name' => env('APP_NAME', 'Acheri Food Bd'),
    'logo' => 'images/logo.png',

    'whatsapp' => env('SITE_WHATSAPP', '8801719507693'),
    'phone' => env('SITE_PHONE', '01719507693'),
    'email' => env('SITE_EMAIL', 'santahardigitalpostoffice@gmail.com'),
    'address' => env('SITE_ADDRESS', 'Bogura, Dhaka, Bangladesh'),

    'delivery_charge' => (int) env('SITE_DELIVERY_CHARGE', 60),

    'social' => [
        'facebook' => env('SITE_FACEBOOK', '#'),
        'instagram' => env('SITE_INSTAGRAM', '#'),
        'youtube' => env('SITE_YOUTUBE', '#'),
        'whatsapp' => 'https://wa.me/'.env('SITE_WHATSAPP', '8801719507693'),
    ],

    'hero' => [
        ['image' => 'images/banner-1.jpeg', 'link' => '/products'],
        ['image' => 'images/banner-2.png', 'link' => '/products'],
    ],

];
