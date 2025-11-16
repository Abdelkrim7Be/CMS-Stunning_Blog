<?php

namespace App\Core;

/**
 * Middleware Class
 * 
 * Provides middleware functionality for request filtering and authentication.
 * Middleware runs before controller actions to check permissions, validate data, etc.
 */
class Middleware
{
    /**
     * Check if user is authenticated
     * Redirect to login if not
     */
    public static function auth(): void
    {
        if (!Session::isAuthenticated()) {
            Session::flash('error', 'Please login to access this page');
            View::redirect('/login');
        }
    }

    /**
     * Check if user is a guest (not authenticated)
     * Redirect to dashboard if authenticated
     */
    public static function guest(): void
    {
        if (Session::isAuthenticated()) {
            View::redirect('/admin/dashboard');
        }
    }

    /**
     * Check if user has a specific permission
     * 
     * @param string $permission
     * @param string|null $errorMessage
     */
    public static function permission(string $permission, ?string $errorMessage = null): void
    {
        if (!Session::isAuthenticated()) {
            Session::flash('error', 'Please login to access this page');
            View::redirect('/login');
        }

        if (!Session::can($permission)) {
            Session::flash('error', $errorMessage ?? 'You do not have permission to perform this action');
            View::redirect('/admin/dashboard');
        }
    }

    /**
     * Check if user has a specific role
     * 
     * @param string $role
     * @param string|null $errorMessage
     */
    public static function role(string $role, ?string $errorMessage = null): void
    {
        if (!Session::isAuthenticated()) {
            Session::flash('error', 'Please login to access this page');
            View::redirect('/login');
        }

        if (!Session::hasRole($role)) {
            Session::flash('error', $errorMessage ?? "You need {$role} role to access this page");
            View::redirect('/admin/dashboard');
        }
    }

    /**
     * Check if user has minimum role level
     * 
     * @param string $minimumRole
     * @param string|null $errorMessage
     */
    public static function minimumRole(string $minimumRole, ?string $errorMessage = null): void
    {
        if (!Session::isAuthenticated()) {
            Session::flash('error', 'Please login to access this page');
            View::redirect('/login');
        }

        if (!Session::isRoleOrHigher($minimumRole)) {
            Session::flash('error', $errorMessage ?? 'You do not have sufficient permissions');
            View::redirect('/admin/dashboard');
        }
    }

    /**
     * Check multiple permissions (user must have at least one)
     * 
     * @param array $permissions
     * @param string|null $errorMessage
     */
    public static function anyPermission(array $permissions, ?string $errorMessage = null): void
    {
        if (!Session::isAuthenticated()) {
            Session::flash('error', 'Please login to access this page');
            View::redirect('/login');
        }

        foreach ($permissions as $permission) {
            if (Session::can($permission)) {
                return;
            }
        }

        Session::flash('error', $errorMessage ?? 'You do not have permission to perform this action');
        View::redirect('/admin/dashboard');
    }

    /**
     * Check multiple permissions (user must have all of them)
     * 
     * @param array $permissions
     * @param string|null $errorMessage
     */
    public static function allPermissions(array $permissions, ?string $errorMessage = null): void
    {
        if (!Session::isAuthenticated()) {
            Session::flash('error', 'Please login to access this page');
            View::redirect('/login');
        }

        foreach ($permissions as $permission) {
            if (!Session::can($permission)) {
                Session::flash('error', $errorMessage ?? 'You do not have all required permissions');
                View::redirect('/admin/dashboard');
                return;
            }
        }
    }

    /**
     * Verify CSRF token
     * 
     * @param string|null $token
     */
    public static function csrf(?string $token = null): void
    {
        if ($token === null && isset($_POST['csrf_token'])) {
            $token = $_POST['csrf_token'];
        }

        $sessionToken = Session::get('csrf_token');

        if (!$token || !$sessionToken || !hash_equals($sessionToken, $token)) {
            Session::flash('error', 'Invalid security token. Please try again.');
            View::redirectBack();
        }
    }

    /**
     * Rate limiting middleware
     * Prevent too many requests in a short time
     * 
     * @param int $maxAttempts
     * @param int $decaySeconds
     * @param string $identifier
     */
    public static function rateLimit(int $maxAttempts = 60, int $decaySeconds = 60, string $identifier = 'global'): void
    {
        $key = 'rate_limit_' . $identifier . '_' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
        $attempts = Session::get($key, []);

        // Clean old attempts
        $now = time();
        $attempts = array_filter($attempts, function ($timestamp) use ($now, $decaySeconds) {
            return $timestamp > ($now - $decaySeconds);
        });

        if (count($attempts) >= $maxAttempts) {
            Session::flash('error', 'Too many requests. Please try again later.');
            View::json(['error' => 'Rate limit exceeded'], 429);
            exit;
        }

        $attempts[] = $now;
        Session::set($key, $attempts);
    }

    /**
     * Verify resource ownership
     * Check if current user owns the resource
     * 
     * @param mixed $resource
     * @param string $ownerField
     */
    public static function owns($resource, string $ownerField = 'author'): bool
    {
        if (!Session::isAuthenticated()) {
            return false;
        }

        $username = Session::username();

        if (is_array($resource)) {
            return isset($resource[$ownerField]) && $resource[$ownerField] === $username;
        }

        if (is_object($resource)) {
            return isset($resource->$ownerField) && $resource->$ownerField === $username;
        }

        return false;
    }

    /**
     * Require resource ownership or specific permission
     * 
     * @param mixed $resource
     * @param string $permission
     * @param string $ownerField
     * @param string|null $errorMessage
     */
    public static function ownsOrCan($resource, string $permission, string $ownerField = 'author', ?string $errorMessage = null): void
    {
        if (!Session::isAuthenticated()) {
            Session::flash('error', 'Please login to access this page');
            View::redirect('/login');
        }

        if (Session::can($permission)) {
            return;
        }

        if (self::owns($resource, $ownerField)) {
            return;
        }

        Session::flash('error', $errorMessage ?? 'You do not have permission to perform this action');
        View::redirect('/admin/dashboard');
    }
}
