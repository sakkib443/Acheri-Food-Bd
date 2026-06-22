<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Storefront settings
    |--------------------------------------------------------------------------
    | Central place for contact details, social links, delivery charge and the
    | home hero banners. Override any value via the matching .env key.
    */

    'whatsapp' => env('SITE_WHATSAPP', '8801700000000'),
    'phone' => env('SITE_PHONE', '+880 1700-000000'),
    'email' => env('SITE_EMAIL', 'info@acherifoodbd.com'),
    'address' => env('SITE_ADDRESS', 'Dhaka, Bangladesh'),

    'delivery_charge' => (int) env('SITE_DELIVERY_CHARGE', 60),

    'social' => [
        'facebook' => env('SITE_FACEBOOK', '#'),
        'instagram' => env('SITE_INSTAGRAM', '#'),
        'youtube' => env('SITE_YOUTUBE', '#'),
        'whatsapp' => 'https://wa.me/'.env('SITE_WHATSAPP', '8801700000000'),
    ],

    'hero' => [
        ['image' => 'images/banner-1.jpeg', 'link' => '/products'],
        ['image' => 'images/banner-2.png', 'link' => '/products'],
    ],

];
