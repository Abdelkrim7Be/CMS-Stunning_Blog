<div class="space-y-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-shield-alt mr-2"></i>Role Management System
            </h1>
            <p class="text-gray-600 mt-1">Manage user roles, permissions, and access control</p>
        </div>
        <div class="flex gap-3">
            <a href="/admin/roles/assign"
                class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-user-tag mr-2"></i> Assign Roles
            </a>
            <a href="/admin/admins/create"
                class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2"></i> Create User
            </a>
        </div>
    </div>

    <?php

    use App\Core\Role;
    use App\Core\Session;
    use App\Models\User;

    // Only super admins can see this page
    if (!Session::hasRole(Role::SUPER_ADMIN)):
    ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                <p class="font-medium">Only Super Administrators can access this page.</p>
            </div>
        </div>
    <?php
    else:
        // Get role statistics
        $roleStats = User::getRoleStats();
    ?>

        <!-- Role Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Super Admin Card -->
            <div class="bg-white border-2 border-red-200 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="text-xs font-bold uppercase mb-2 text-red-600">
                            Super Administrator
                        </div>
                        <div class="text-2xl font-bold mb-1 text-gray-900">
                            👑 Level 4
                        </div>
                        <div class="text-sm text-gray-600 mb-4">
                            <?= $roleStats['super_admin'] ?? 0 ?> users
                        </div>
                        <div class="flex flex-col gap-2">
                            <a href="/admin/roles/users/super_admin"
                                class="text-center px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-sm font-medium transition-colors">
                                View Users
                            </a>
                            <a href="/admin/roles/permissions/super_admin"
                                class="text-center px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                                Permissions
                            </a>
                        </div>
                    </div>
                    <div class="ml-3">
                        <i class="fas fa-crown text-5xl text-red-100"></i>
                    </div>
                </div>
            </div>

            <!-- Admin Card -->
            <div class="bg-white border-2 border-orange-200 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="text-xs font-bold uppercase mb-2 text-orange-600">
                            Administrator
                        </div>
                        <div class="text-2xl font-bold mb-1 text-gray-900">
                            ⚡ Level 3
                        </div>
                        <div class="text-sm text-gray-600 mb-4">
                            <?= $roleStats['admin'] ?? 0 ?> users
                        </div>
                        <div class="flex flex-col gap-2">
                            <a href="/admin/roles/users/admin"
                                class="text-center px-3 py-1.5 bg-orange-50 hover:bg-orange-100 text-orange-700 rounded-lg text-sm font-medium transition-colors">
                                View Users
                            </a>
                            <a href="/admin/roles/permissions/admin"
                                class="text-center px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                                Permissions
                            </a>
                        </div>
                    </div>
                    <div class="ml-3">
                        <i class="fas fa-user-shield text-5xl text-orange-100"></i>
                    </div>
                </div>
            </div>

            <!-- Editor Card -->
            <div class="bg-white border-2 border-blue-200 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="text-xs font-bold uppercase mb-2 text-blue-600">
                            Editor
                        </div>
                        <div class="text-2xl font-bold mb-1 text-gray-900">
                            ✏️ Level 2
                        </div>
                        <div class="text-sm text-gray-600 mb-4">
                            <?= $roleStats['editor'] ?? 0 ?> users
                        </div>
                        <div class="flex flex-col gap-2">
                            <a href="/admin/roles/users/editor"
                                class="text-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-sm font-medium transition-colors">
                                View Users
                            </a>
                            <a href="/admin/roles/permissions/editor"
                                class="text-center px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                                Permissions
                            </a>
                        </div>
                    </div>
                    <div class="ml-3">
                        <i class="fas fa-edit text-5xl text-blue-100"></i>
                    </div>
                </div>
            </div>

            <!-- Author Card -->
            <div class="bg-white border-2 border-gray-200 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="text-xs font-bold uppercase mb-2 text-gray-600">
                            Author
                        </div>
                        <div class="text-2xl font-bold mb-1 text-gray-900">
                            ✍️ Level 1
                        </div>
                        <div class="text-sm text-gray-600 mb-4">
                            <?= $roleStats['author'] ?? 0 ?> users
                        </div>
                        <div class="flex flex-col gap-2">
                            <a href="/admin/roles/users/author"
                                class="text-center px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                                View Users
                            </a>
                            <a href="/admin/roles/permissions/author"
                                class="text-center px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                                Permissions
                            </a>
                        </div>
                    </div>
                    <div class="ml-3">
                        <i class="fas fa-pen text-5xl text-gray-100"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permission Matrix -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-table mr-2"></i>Permission Matrix
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider" style="width: 300px;">
                                Permission
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider" style="width: 120px;">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    👑 Super
                                </span>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider" style="width: 120px;">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    ⚡ Admin
                                </span>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider" style="width: 120px;">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                    ✏️ Editor
                                </span>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider" style="width: 120px;">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                    ✍️ Author
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        $permissions = [
                            'User Management' => [
                                'manage_super_admins' => 'Manage Super Admins',
                                'manage_admins' => 'Manage Admins/Editors/Authors',
                                'manage_roles' => 'Manage Roles',
                            ],
                            'Content Management' => [
                                'manage_categories' => 'Manage Categories',
                                'manage_all_posts' => 'Manage All Posts',
                                'create_post' => 'Create Posts',
                                'edit_own_post' => 'Edit Own Posts',
                                'delete_any_post' => 'Delete Any Post',
                                'delete_own_post' => 'Delete Own Posts',
                            ],
                            'Comment Management' => [
                                'manage_all_comments' => 'Manage All Comments',
                                'approve_comments' => 'Approve Comments',
                                'delete_any_comment' => 'Delete Any Comment',
                            ],
                            'System' => [
                                'manage_system_settings' => 'System Settings',
                                'view_all_analytics' => 'View All Analytics',
                                'view_analytics' => 'View Analytics',
                                'view_basic_stats' => 'View Basic Stats',
                                'view_own_stats' => 'View Own Stats',
                            ],
                        ];

                        foreach ($permissions as $category => $perms):
                        ?>
                            <tr class="bg-gray-100">
                                <td colspan="5" class="px-6 py-3">
                                    <strong class="text-gray-900">
                                        <i class="fas fa-folder mr-2"></i><?= $category ?>
                                    </strong>
                                </td>
                            </tr>
                            <?php foreach ($perms as $perm => $label): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-3 text-sm text-gray-900"><?= $label ?></td>
                                    <td class="px-6 py-3 text-center">
                                        <?php if (Role::hasPermission(Role::SUPER_ADMIN, $perm)): ?>
                                            <i class="fas fa-check-circle text-green-600 text-lg"></i>
                                        <?php else: ?>
                                            <i class="fas fa-times-circle text-red-600 text-lg"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <?php if (Role::hasPermission(Role::ADMIN, $perm)): ?>
                                            <i class="fas fa-check-circle text-green-600 text-lg"></i>
                                        <?php else: ?>
                                            <i class="fas fa-times-circle text-red-600 text-lg"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <?php if (Role::hasPermission(Role::EDITOR, $perm)): ?>
                                            <i class="fas fa-check-circle text-green-600 text-lg"></i>
                                        <?php else: ?>
                                            <i class="fas fa-times-circle text-red-600 text-lg"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <?php if (Role::hasPermission(Role::AUTHOR, $perm)): ?>
                                            <i class="fas fa-check-circle text-green-600 text-lg"></i>
                                        <?php else: ?>
                                            <i class="fas fa-times-circle text-red-600 text-lg"></i>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Role Hierarchy & Security Rules -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
            <!-- Role Hierarchy -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-sitemap mr-2"></i>Role Hierarchy
                    </h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-6">
                        Users can only manage users with <strong class="text-gray-900">lower roles</strong> than their own:
                    </p>

                    <div class="space-y-4">
                        <div class="text-center">
                            <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg text-lg font-bold shadow-lg">
                                👑 Super Administrator
                            </div>
                            <div class="h-6 w-0.5 bg-gray-300 mx-auto"></div>
                        </div>

                        <div class="text-center">
                            <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-600 text-white rounded-lg text-base font-bold shadow-lg">
                                ⚡ Administrator
                            </div>
                            <div class="h-6 w-0.5 bg-gray-300 mx-auto"></div>
                        </div>

                        <div class="text-center">
                            <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-lg text-base font-bold shadow-lg">
                                ✏️ Editor
                            </div>
                            <div class="h-6 w-0.5 bg-gray-300 mx-auto"></div>
                        </div>

                        <div class="text-center">
                            <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-800 text-white rounded-lg text-base font-bold shadow-lg">
                                ✍️ Author
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg mt-6">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle mr-3 text-xl mt-0.5"></i>
                            <div>
                                <strong class="font-bold">Note:</strong> Higher roles inherit all permissions from lower roles.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Rules -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-shield-alt mr-2"></i>Security Rules
                    </h2>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 mb-3">Role Assignment Rules:</h3>
                    <ul class="space-y-2 mb-6 text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                            <span>Users can only assign roles <strong>lower</strong> than their own</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                            <span>Users cannot change their own role</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                            <span>Users cannot delete their own account</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                            <span>Users cannot edit/delete users with equal or higher roles</span>
                        </li>
                    </ul>

                    <h3 class="font-bold text-gray-900 mb-3">Permission Checks:</h3>
                    <ul class="space-y-2 mb-6 text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                            <span>All permissions are checked server-side</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                            <span>Session regeneration on login prevents fixation</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                            <span>CSRF protection available for all forms</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                            <span>Role information cached in session</span>
                        </li>
                    </ul>

                    <h3 class="font-bold text-gray-900 mb-3">Default Roles:</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                            <span>New users: <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 ml-1">Author</span></span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                            <span>First user: Can be set to <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 ml-1">Super Admin</span></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>