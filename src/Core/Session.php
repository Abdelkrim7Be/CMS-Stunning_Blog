<?php

namespace App\Core;

/**
 * Session Class
 * 
 * Manages session data with a clean, secure interface.
 * 
 * FEATURES:
 * - Flash messages (shown once, then removed)
 * - Easy get/set/delete operations
 * - Authentication helper methods
 * - Role-based access control
 */
class Session
{
    /**
     * Start the session (called in index.php)
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Set a session value
     * 
     * @param string $key
     * @param mixed $value
     */
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get a session value
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Check if session key exists
     * 
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove a session value
     * 
     * @param string $key
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Set a flash message (shown once, then removed)
     * 
     * @param string $type (success, error, warning, info)
     * @param string $message
     */
    public static function flash(string $type, string $message): void
    {
        $_SESSION['flash'][$type] = $message;
    }

    /**
     * Get flash message and remove it
     * 
     * @param string $type
     * @return string|null
     */
    public static function getFlash(string $type): ?string
    {
        if (isset($_SESSION['flash'][$type])) {
            $message = $_SESSION['flash'][$type];
            unset($_SESSION['flash'][$type]);
            return $message;
        }
        return null;
    }

    /**
     * Check if user is authenticated
     * 
     * @return bool
     */
    public static function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Get authenticated user ID
     * 
     * @return int|null
     */
    public static function userId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Get authenticated username
     * 
     * @return string|null
     */
    public static function username(): ?string
    {
        return $_SESSION['username'] ?? null;
    }

    /**
     * Get authenticated user role
     * 
     * @return string|null
     */
    public static function role(): ?string
    {
        return $_SESSION['user_role'] ?? null;
    }

    /**
     * Set user authentication
     * 
     * @param int $userId
     * @param string $username
     * @param string $adminName
     * @param string $role
     */
    public static function login(int $userId, string $username, string $adminName, string $role = 'author'): void
    {
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['admin_name'] = $adminName;
        $_SESSION['user_role'] = $role;

        // Regenerate session ID to prevent session fixation attacks
        session_regenerate_id(true);
    }

    /**
     * Check if user has a specific permission
     * 
     * @param string $permission
     * @return bool
     */
    public static function can(string $permission): bool
    {
        $role = self::role();
        if (!$role) {
            return false;
        }

        return Role::hasPermission($role, $permission);
    }

    /**
     * Check if user has a specific role
     * 
     * @param string $role
     * @return bool
     */
    public static function hasRole(string $role): bool
    {
        return self::role() === $role;
    }

    /**
     * Check if user role is higher or equal to given role
     * 
     * @param string $role
     * @return bool
     */
    public static function isRoleOrHigher(string $role): bool
    {
        $userRole = self::role();
        if (!$userRole) {
            return false;
        }

        return Role::isHigherOrEqual($userRole, $role);
    }

    /**
     * Clear user authentication
     */
    public static function logout(): void
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_role']);
        unset($_SESSION['username']);
        unset($_SESSION['admin_name']);

        // Destroy the session
        session_destroy();
    }

    /**
     * Destroy all session data
     */
    public static function destroy(): void
    {
        session_destroy();
        $_SESSION = [];
    }

    /**
     * Generate CSRF token
     * 
     * @return string
     */
    public static function generateCsrfToken(): string
    {
        if (!self::has('csrf_token')) {
            $token = bin2hex(random_bytes(32));
            self::set('csrf_token', $token);
        }

        return self::get('csrf_token');
    }

    /**
     * Get CSRF token (generates if doesn't exist)
     * 
     * @return string
     */
    public static function csrfToken(): string
    {
        return self::generateCsrfToken();
    }

    /**
     * Verify CSRF token
     * 
     * @param string $token
     * @return bool
     */
    public static function verifyCsrfToken(string $token): bool
    {
        $sessionToken = self::get('csrf_token');

        if (!$sessionToken) {
            return false;
        }

        return hash_equals($sessionToken, $token);
    }

    /**
     * Get CSRF input field HTML
     * 
     * @return string
     */
    public static function csrfField(): string
    {
        $token = self::csrfToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }
}
