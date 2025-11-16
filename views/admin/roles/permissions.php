<?php

use App\Core\Role;

/**
 * Helper function to get permission descriptions
 */
if (!function_exists('getPermissionDescription')) {
    function getPermissionDescription(string $permission): string
    {
        $descriptions = [
            'manage_super_admins' => 'Can create, edit, and delete super administrators',
            'manage_admins' => 'Can create, edit, and delete admin users',
            'manage_roles' => 'Can assign and modify user roles',
            'manage_system_settings' => 'Can configure system-wide settings',
            'view_all_analytics' => 'Can view all analytics and statistics',
            'manage_all_posts' => 'Can edit and delete any post',
            'manage_all_comments' => 'Can edit and delete any comment',
            'manage_categories' => 'Can create, edit, and delete categories',
            'delete_any_post' => 'Can delete posts created by any user',
            'delete_any_comment' => 'Can delete comments by any user',
            'approve_comments' => 'Can approve or reject pending comments',
            'view_analytics' => 'Can view analytics dashboard',
            'view_basic_stats' => 'Can view basic statistics',
            'create_post' => 'Can create new posts',
            'edit_own_post' => 'Can edit own posts only',
            'delete_own_post' => 'Can delete own posts only',
            'view_own_stats' => 'Can view statistics for own content',
        ];

        return $descriptions[$permission] ?? 'No description available';
    }
}
?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <?= $role_info['icon'] ?> <?= htmlspecialchars($role_info['name']) ?> - Permissions
            </h1>
            <p class="text-gray-600 mt-1">View all permissions for this role</p>
        </div>
        <a href="/admin/roles"
            class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-arrow-left mr-2"></i> Back to Roles
        </a>
    </div>

    <!-- Role Information -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-info-circle mr-2"></i>Role Information
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <p class="text-sm font-semibold text-gray-700 mb-2">Role Key:</p>
                    <code class="px-3 py-1 bg-gray-100 text-gray-900 rounded font-mono text-sm"><?= htmlspecialchars($role) ?></code>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-700 mb-2">Display Name:</p>
                    <p class="text-gray-900"><?= htmlspecialchars($role_info['name']) ?></p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-700 mb-2">Hierarchy Level:</p>
                    <p class="text-gray-900"><?= $role_info['level'] ?> / 4</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-700 mb-2">Total Permissions:</p>
                    <p class="text-gray-900 text-2xl font-bold"><?= $role_info['permission_count'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-shield-alt mr-2 text-green-600"></i>Granted Permissions
            </h2>
        </div>
        <div class="p-6">
            <?php if (empty($permissions)): ?>
                <p class="text-gray-500 text-center py-8">This role has no specific permissions assigned.</p>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($permissions as $permission): ?>
                        <div class="flex items-start p-4 bg-white rounded-lg border-2 border-green-200">
                            <i class="fas fa-check-circle text-green-600 text-xl mr-3 mt-0.5"></i>
                            <div>
                                <p class="font-semibold text-gray-900"><?= htmlspecialchars($permission) ?></p>
                                <p class="text-sm text-gray-600 mt-1">
                                    <?= getPermissionDescription($permission) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Missing Permissions -->
    <?php
    $missingPermissions = array_diff($all_permissions, $permissions);
    if (!empty($missingPermissions)):
    ?>
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-times-circle mr-2 text-gray-400"></i>Not Granted
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($missingPermissions as $permission): ?>
                        <div class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <i class="fas fa-times-circle text-gray-400 text-xl mr-3 mt-0.5"></i>
                            <div>
                                <p class="text-gray-500"><?= htmlspecialchars($permission) ?></p>
                                <p class="text-sm text-gray-400 mt-1">
                                    <?= getPermissionDescription($permission) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>