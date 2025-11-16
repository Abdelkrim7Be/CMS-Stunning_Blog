<?php

namespace App\Core;

/**
 * Request Class
 * 
 * Provides a clean interface to access HTTP request data.
 * Replaces direct access to $_GET, $_POST, $_SERVER superglobals.
 * 
 * WHY?
 * - Cleaner code: $request->get('username') vs $_POST['username']
 * - Security: Built-in sanitization and validation
 * - Testability: Can mock request data in tests
 */
class Request
{
    /**
     * Get a value from GET request
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    /**
     * Get a value from POST request
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function post(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * Get all POST data
     * 
     * @return array
     */
    public function all(): array
    {
        return $_POST;
    }

    /**
     * Check if key exists in request
     * 
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($_POST[$key]) || isset($_GET[$key]);
    }

    /**
     * Get request method (GET, POST, etc.)
     * 
     * @return string
     */
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Check if request is POST
     * 
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->method() === 'POST';
    }

    /**
     * Check if request is GET
     * 
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->method() === 'GET';
    }

    /**
     * Get request URI
     * 
     * @return string
     */
    public function uri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Get request path (without query string)
     * 
     * @return string
     */
    public function path(): string
    {
        return strtok($_SERVER['REQUEST_URI'], '?');
    }

    /**
     * Get uploaded file
     * 
     * @param string $key
     * @return array|null
     */
    public function file(string $key): ?array
    {
        return $_FILES[$key] ?? null;
    }

    /**
     * Sanitize input to prevent XSS
     * 
     * @param string $data
     * @return string
     */
    public function sanitize(string $data): string
    {
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }
}
