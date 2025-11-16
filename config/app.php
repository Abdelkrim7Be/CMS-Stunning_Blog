<?php

/**
 * Application Configuration
 * 
 * This file contains general application settings.
 * Separating configuration from code makes your app more maintainable.
 */

return [
    // Application name
    'app_name' => 'Stunning Blog CMS',

    // Application URL (without trailing slash)
    'app_url' => 'http://localhost/cms-stunning-blog/public',

    // Debug mode (ALWAYS set to false in production!)
    // When true: Shows detailed error messages
    // When false: Hides errors from users, logs them instead
    'debug' => true,

    // Timezone
    'timezone' => 'UTC',

    // Default language
    'language' => 'en',

    // Session configuration
    'session' => [
        'lifetime' => 7200, // 2 hours in seconds
        'cookie_name' => 'cms_session',
    ],

    // Pagination
    'posts_per_page' => 10,

    // File upload settings
    'upload' => [
        'max_size' => 5242880, // 5MB in bytes
        'allowed_types' => ['jpg', 'jpeg', 'png', 'gif'],
        'path' => PUBLIC_PATH . '/uploads',
    ],

    // Security
    'security' => [
        'password_min_length' => 8,
        'session_regenerate' => true,
    ],
];
