<?php

namespace App\Core;

/**
 * Role Management Class
 * 
 * Defines roles and their permissions for the CMS
 * 
 * ROLE HIERARCHY (from highest to lowest):
 * 1. super_admin - Full system access, can manage all admins and settings
 * 2. admin       - Can manage content, categories, and comments, can manage editors/authors
 * 3. editor      - Can manage all posts and comments, but cannot manage users
 * 4. author      - Can only manage their own posts
 */
class Role
{
    // Role constants
    public const SUPER_ADMIN = 'super_admin';
    public const ADMIN = 'admin';
    public const EDITOR = 'editor';
    public const AUTHOR = 'author';

    /**
     * All available roles
     */
    public const ROLES = [
        self::SUPER_ADMIN => 'Super Administrator',
        self::ADMIN => 'Administrator',
        self::EDITOR => 'Editor',
        self::AUTHOR => 'Author',
    ];

    /**
     * Role hierarchy (higher number = more power)
     */
    private const HIERARCHY = [
        self::AUTHOR => 1,
        self::EDITOR => 2,
        self::ADMIN => 3,
        self::SUPER_ADMIN => 4,
    ];

    /**
     * Permission definitions for each role
     */
    private const PERMISSIONS = [
        self::SUPER_ADMIN => [
            // Full access to everything
            'manage_super_admins',
            'manage_admins',
            'manage_roles',
            'manage_system_settings',
            'view_all_analytics',
            'manage_all_posts',
            'manage_all_comments',
            'manage_categories',
            'delete_any_post',
            'delete_any_comment',
            'approve_comments',
        ],
        self::ADMIN => [
            // Cannot manage super admins or system settings
            'manage_admins',           // Can manage editor/author only
            'manage_all_posts',
            'manage_all_comments',
            'manage_categories',
            'delete_any_post',
            'delete_any_comment',
            'approve_comments',
            'view_analytics',
        ],
        self::EDITOR => [
            // Content management only
            'manage_all_posts',
            'manage_all_comments',
            'delete_any_post',
            'delete_any_comment',
            'approve_comments',
            'view_basic_stats',
        ],
        self::AUTHOR => [
            // Own content only
            'create_post',
            'edit_own_post',
            'delete_own_post',
            'view_own_stats',
        ],
    ];

    /**
     * Check if a role has a specific permission
     * 
     * @param string $role
     * @param string $permission
     * @return bool
     */
    public static function hasPermission(string $role, string $permission): bool
    {
        if (!isset(self::PERMISSIONS[$role])) {
            return false;
        }

        return in_array($permission, self::PERMISSIONS[$role], true);
    }

    /**
     * Check if role1 is higher or equal to role2 in hierarchy
     * 
     * @param string $role1
     * @param string $role2
     * @return bool
     */
    public static function isHigherOrEqual(string $role1, string $role2): bool
    {
        $level1 = self::HIERARCHY[$role1] ?? 0;
        $level2 = self::HIERARCHY[$role2] ?? 0;

        return $level1 >= $level2;
    }

    /**
     * Check if role1 is higher than role2 in hierarchy
     * 
     * @param string $role1
     * @param string $role2
     * @return bool
     */
    public static function isHigherThan(string $role1, string $role2): bool
    {
        $level1 = self::HIERARCHY[$role1] ?? 0;
        $level2 = self::HIERARCHY[$role2] ?? 0;

        return $level1 > $level2;
    }

    /**
     * Get all roles that a user with given role can manage
     * 
     * @param string $role
     * @return array
     */
    public static function getManageableRoles(string $role): array
    {
        $currentLevel = self::HIERARCHY[$role] ?? 0;
        $manageable = [];

        foreach (self::HIERARCHY as $r => $level) {
            if ($level < $currentLevel) {
                $manageable[$r] = self::ROLES[$r];
            }
        }

        return $manageable;
    }

    /**
     * Get role display name
     * 
     * @param string $role
     * @return string
     */
    public static function getName(string $role): string
    {
        return self::ROLES[$role] ?? 'Unknown';
    }

    /**
     * Get all roles
     * 
     * @return array
     */
    public static function all(): array
    {
        return self::ROLES;
    }

    /**
     * Validate if role exists
     * 
     * @param string $role
     * @return bool
     */
    public static function isValid(string $role): bool
    {
        return isset(self::ROLES[$role]);
    }

    /**
     * Get role badge color for UI
     * 
     * @param string $role
     * @return string
     */
    public static function getBadgeClass(string $role): string
    {
        return match ($role) {
            self::SUPER_ADMIN => 'badge-danger',
            self::ADMIN => 'badge-warning',
            self::EDITOR => 'badge-info',
            self::AUTHOR => 'badge-secondary',
            default => 'badge-light',
        };
    }

    /**
     * Get role icon for UI
     * 
     * @param string $role
     * @return string
     */
    public static function getIcon(string $role): string
    {
        return match ($role) {
            self::SUPER_ADMIN => '👑',
            self::ADMIN => '⚡',
            self::EDITOR => '✏️',
            self::AUTHOR => '✍️',
            default => '👤',
        };
    }

    /**
     * Get all roles with their details
     * 
     * @return array
     */
    public static function getAllRoles(): array
    {
        $roles = [];
        foreach (self::ROLES as $key => $name) {
            $roles[] = [
                'key' => $key,
                'name' => $name,
                'level' => self::HIERARCHY[$key],
                'permissions' => self::PERMISSIONS[$key] ?? [],
                'icon' => self::getIcon($key),
                'badge_class' => self::getBadgeClass($key),
            ];
        }
        return $roles;
    }

    /**
     * Get all available permissions across all roles
     * 
     * @return array
     */
    public static function getAllPermissions(): array
    {
        $permissions = [];
        foreach (self::PERMISSIONS as $role => $perms) {
            foreach ($perms as $perm) {
                if (!in_array($perm, $permissions)) {
                    $permissions[] = $perm;
                }
            }
        }
        sort($permissions);
        return $permissions;
    }

    /**
     * Validate if role exists (alias for isValid)
     * 
     * @param string $role
     * @return bool
     */
    public static function isValidRole(string $role): bool
    {
        return self::isValid($role);
    }

    /**
     * Get permissions for a specific role
     * 
     * @param string $role
     * @return array
     */
    public static function getPermissionsForRole(string $role): array
    {
        return self::PERMISSIONS[$role] ?? [];
    }

    /**
     * Get detailed information about a role
     * 
     * @param string $role
     * @return array
     */
    public static function getRoleInfo(string $role): array
    {
        if (!self::isValid($role)) {
            return [];
        }

        return [
            'key' => $role,
            'name' => self::ROLES[$role],
            'level' => self::HIERARCHY[$role],
            'permissions' => self::PERMISSIONS[$role] ?? [],
            'permission_count' => count(self::PERMISSIONS[$role] ?? []),
            'icon' => self::getIcon($role),
            'badge_class' => self::getBadgeClass($role),
        ];
    }

    /**
     * Get permissions organized by category
     * 
     * @return array
     */
    public static function getPermissionsByCategory(): array
    {
        return [
            'User Management' => [
                'manage_super_admins',
                'manage_admins',
                'manage_roles',
            ],
            'Content Management' => [
                'manage_all_posts',
                'create_post',
                'edit_own_post',
                'delete_own_post',
                'delete_any_post',
            ],
            'Comments' => [
                'manage_all_comments',
                'delete_any_comment',
                'approve_comments',
            ],
            'Categories' => [
                'manage_categories',
            ],
            'System' => [
                'manage_system_settings',
                'view_all_analytics',
                'view_analytics',
                'view_basic_stats',
                'view_own_stats',
            ],
        ];
    }
}
