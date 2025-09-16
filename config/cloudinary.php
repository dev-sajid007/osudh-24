<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Cloudinary settings. Cloudinary is a cloud
    | service that offers a solution to a web application's entire image
    | management pipeline.
    |
    */

    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
    'api_key' => env('CLOUDINARY_API_KEY'),
    'api_secret' => env('CLOUDINARY_API_SECRET'),
    'url' => env('CLOUDINARY_URL'),

    /*
    |--------------------------------------------------------------------------
    | Upload Settings
    |--------------------------------------------------------------------------
    |
    | Configure default upload settings for your images
    |
    */

    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET', 'unsigned_default'),

    'folders' => [
        'categories' => 'pharmacy/categories',
        'products' => 'pharmacy/products',
        'users' => 'pharmacy/users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Transformation Settings
    |--------------------------------------------------------------------------
    |
    | Default transformations to apply to uploaded images
    |
    */

    'transformations' => [
        'category' => [
            'thumbnail' => ['width' => 150, 'height' => 150, 'crop' => 'fill'],
            'medium' => ['width' => 400, 'height' => 400, 'crop' => 'fill'],
            'large' => ['width' => 800, 'height' => 600, 'crop' => 'fill'],
        ],
        'product' => [
            'thumbnail' => ['width' => 100, 'height' => 100, 'crop' => 'fill'],
            'medium' => ['width' => 300, 'height' => 300, 'crop' => 'fill'],
            'large' => ['width' => 600, 'height' => 600, 'crop' => 'fill'],
        ],
    ],
];
