<?php

return [

    'frontend_url' => rtrim(
        env('FRONTEND_URL', 'https://sleepq.in'),
        '/'
    ),

    'frontend_public_path' => base_path(
        env('FRONTEND_PUBLIC_PATH', '../public')
    ),

    'product_images_path' => base_path(
        env('FRONTEND_PUBLIC_PATH', '../public') . '/images/products'
    ),

];