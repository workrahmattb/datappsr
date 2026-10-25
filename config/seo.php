<?php

return [
    'url' => env('SEO_URL', 'https://ppsyafaaturrasul.com'),
    'redirect_domain' => env('SEO_REDIRECT_DOMAIN', env('APP_ENV') === 'production'),
];
