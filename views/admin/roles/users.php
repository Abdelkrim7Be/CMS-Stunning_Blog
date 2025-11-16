<?php

use App\Core\Role;
?>

<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <?= $role_info['icon'] ?> <?= htmlspecialchars($role_info['name']) ?> Users
            </h1>
            <p class="text-gray-600 mt-1">Manage users with <?= htmlspecialchars($role_info['name']) ?> role</p>
        </div>
        <div class="flex gap-3">
            <a href="/admin/roles/assign"
                class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-user-tag mr-2"></i> Assign Roles
            </a>
            <a href="/admin/roles"
                class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-arrow-left mr-2"></i> Back to Roles
            </a>
        </div>
    </div>

    <!-- Role Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white border-2 border-gray-200 rounded-xl shadow-lg p-6 text-center">
            <div class="text-5xl mb-3"><?= $role_info['icon'] ?></div>
            <h3 class="text-xl font-bold mb-1 text-gray-900"><?= htmlspecialchars($role_info['name']) ?></h3>
            <p class="text-sm text-gray-600">Level <?= $role_info['level'] ?> / 4</p>
        </div>
        <div class="bg-white border-2 border-gray-200 rounded-xl shadow-lg p-6 text-center">
            <div class="text-5xl font-bold mb-3 text-gray-900"><?= count($users) ?></div>
            <h3 class="text-xl font-bold mb-1 text-gray-900">Total Users</h3>
            <p class="text-sm text-gray-600">with this role</p>
        </div>
        <div class="bg-white border-2 border-gray-200 rounded-xl shadow-lg p-6 text-center">
            <div class="text-5xl font-bold mb-3 text-gray-900"><?= $role_info['permission_count'] ?></div>
            <h3 class="text-xl font-bold mb-2 text-gray-900">Permissions</h3>
            <a href="/admin/roles/permissions/<?= $role ?>"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                View All
            </a>
        </div>
        <div class="bg-white border-2 border-gray-200 rounded-xl shadow-lg p-6 text-center">
            <div class="text-5xl mb-3 text-gray-700">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="text-xl font-bold mb-2 text-gray-900">Manage</h3>
            <a href="/admin/admins/create"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                Add User
            </a>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-users mr-2"></i>Users with <?= htmlspecialchars($role_info['name']) ?> Role
            </h2>
        </div>
        <div class="p-6">
            <?php if (empty($users)): ?>
                <div class="text-center py-16">
                    <i class="fas fa-user-slash text-7xl text-gray-300 mb-4"></i>
                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg mb-6 inline-block text-left">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle mr-3 text-xl"></i>
                            <p>No users found with the <strong><?= htmlspecialchars($role_info['name']) ?></strong> role.</p>
                        </div>
                    </div>
                    <div>
                        <a href="/admin/admins/create"
                            class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                            <i class="fas fa-plus mr-2"></i> Create New User
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Username</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Full Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Added By</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Joined Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($users as $user): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?= $user['id'] ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <strong class="text-gray-900"><?= htmlspecialchars($user['username']) ?></strong>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <?= htmlspecialchars($user['aname']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?= Role::getBadgeClass($user['role']) ?>">
                                            <?= Role::getIcon($user['role']) ?> <?= Role::getName($user['role']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?= htmlspecialchars($user['added_by']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?= htmlspecialchars($user['datetime']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <?php if (can('manage_admins')): ?>
                                            <div class="flex items-center gap-2">
                                                <a href="/admin/admins/edit/<?= $user['id'] ?>"
                                                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                    <button
                                                        type="button"
                                                        class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                                                        onclick="openRoleModal<?= $user['id'] ?>()"
                                                        title="Change Role">
                                                        <i class="fas fa-user-tag"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Change Role Modal -->
                                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                <div id="roleModal<?= $user['id'] ?>" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                                                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
                                                        <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-200">
                                                            <h3 class="text-lg font-bold text-gray-900">
                                                                Change Role for <?= htmlspecialchars($user['username']) ?>
                                                            </h3>
                                                            <button type="button" onclick="closeRoleModal<?= $user['id'] ?>()" class="text-gray-400 hover:text-gray-600">
                                                                <i class="fas fa-times text-xl"></i>
                                                            </button>
                                                        </div>
                                                        <form action="/admin/roles/update-user-role" method="POST">
                                                            <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">
                                                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                            <div class="space-y-4">
                                                                <div>
                                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Role:</label>
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?= Role::getBadgeClass($user['role']) ?>">
                                                                        <?= Role::getIcon($user['role']) ?> <?= Role::getName($user['role']) ?>
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <label for="role<?= $user['id'] ?>" class="block text-sm font-medium text-gray-700 mb-2">New Role:</label>
                                                                    <select name="role" id="role<?= $user['id'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent" required>
                                                                        <?php foreach (Role::all() as $roleKey => $roleName): ?>
                                                                            <option value="<?= $roleKey ?>" <?= $roleKey === $user['role'] ? 'selected' : '' ?>>
                                                                                <?= Role::getIcon($roleKey) ?> <?= htmlspecialchars($roleName) ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200">
                                                                <button type="button" onclick="closeRoleModal<?= $user['id'] ?>()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                                                                    Cancel
                                                                </button>
                                                                <button type="submit" class="flex-1 px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                                                                    Update Role
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <script>
                                                    function openRoleModal<?= $user['id'] ?>() {
                                                        document.getElementById('roleModal<?= $user['id'] ?>').classList.remove('hidden');
                                                    }

                                                    function closeRoleModal<?= $user['id'] ?>() {
                                                        document.getElementById('roleModal<?= $user['id'] ?>').classList.add('hidden');
                                                    }
                                                </script>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-gray-400">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h3>
        <div class="flex flex-wrap gap-3">
            <a href="/admin/roles/permissions/<?= $role ?>"
                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-shield-alt mr-2"></i> View Permissions
            </a>
            <a href="/admin/roles/assign"
                class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-user-tag mr-2"></i> Assign Roles
            </a>
            <a href="/admin/admins/create"
                class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2"></i> Create New User
            </a>
        </div>
    </div>
</div>