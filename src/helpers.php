<?php

/**
 * Helper Functions
 * 
 * Global helper functions that can be used throughout the application.
 * These are utility functions that don't fit into any specific class.
 */

use App\Core\Session;

/**
 * Get the base URL
 * 
 * @param string $path
 * @return string
 */
function url(string $path = ''): string
{
    $config = require CONFIG_PATH . '/app.php';
    return rtrim($config['app_url'], '/') . '/' . ltrim($path, '/');
}

/**
 * Get asset URL
 * 
 * @param string $path
 * @return string
 */
function asset(string $path): string
{
    return '/assets/' . ltrim($path, '/');
}

/**
 * Escape HTML to prevent XSS
 * 
 * @param string $string
 * @return string
 */
function e(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Debug helper - dump and die
 * 
 * @param mixed $data
 */
function dd(...$data): void
{
    echo '<pre>';
    foreach ($data as $item) {
        var_dump($item);
    }
    echo '</pre>';
    die();
}

/**
 * Get old input value (for form re-population after validation error)
 * 
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function old(string $key, $default = '')
{
    return Session::get('old_input')[$key] ?? $default;
}

/**
 * Check if user is authenticated
 * 
 * @return bool
 */
function isAuth(): bool
{
    return Session::isAuthenticated();
}

/**
 * Get current user
 * 
 * @return array|null
 */
function currentUser(): ?array
{
    if (!isAuth()) {
        return null;
    }

    return [
        'id' => Session::userId(),
        'username' => Session::username(),
    ];
}

/**
 * Format date
 * 
 * @param string $date
 * @param string $format
 * @return string
 */
function formatDate(string $date, string $format = 'F d, Y'): string
{
    return date($format, strtotime($date));
}

/**
 * Truncate text
 * 
 * @param string $text
 * @param int $length
 * @param string $suffix
 * @return string
 */
function truncate(string $text, int $length = 100, string $suffix = '...'): string
{
    if (strlen($text) <= $length) {
        return $text;
    }

    return substr($text, 0, $length) . $suffix;
}
