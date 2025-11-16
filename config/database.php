<?php

/**
 * Database Configuration
 * 
 * WHY separate this?
 * - Security: Easier to exclude from version control (.gitignore)
 * - Flexibility: Different settings for dev/staging/production
 * - Best practice: Sensitive data should never be hardcoded in business logic
 */

return [
    // Database driver (mysql, pgsql, sqlite)
    'driver' => 'mysql',

    // Database host
    'host' => 'localhost',

    // Database port
    'port' => '3306',

    // Database name
    'database' => 'cms4.2.1',

    // Database username
    'username' => 'root',

    // Database password
    'password' => '',

    // Character set
    'charset' => 'utf8mb4',

    // Collation
    'collation' => 'utf8mb4_unicode_ci',

    // PDO options
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
];
