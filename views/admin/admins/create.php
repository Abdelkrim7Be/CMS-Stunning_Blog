<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create New Admin</h1>
            <p class="text-gray-600 mt-1">Add a new administrator to your team</p>
        </div>
        <a href="/admin/admins"
            class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-arrow-left mr-2"></i> Back to Admins
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Admin Information</h2>
                </div>
                <div class="p-6">
                    <form action="/admin/admins" method="POST" class="space-y-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                Username <span class="text-red-600">*</span>
                            </label>
                            <input type="text"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                                id="username"
                                name="username"
                                required
                                placeholder="Enter username">
                            <p class="mt-2 text-sm text-gray-500">Username must be unique and will be used for login</p>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-600">*</span>
                            </label>
                            <input type="password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                                id="password"
                                name="password"
                                required
                                minlength="4"
                                placeholder="Enter password">
                            <p class="mt-2 text-sm text-gray-500">Minimum 4 characters</p>
                        </div>

                        <div>
                            <label for="aname" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name <span class="text-red-600">*</span>
                            </label>
                            <input type="text"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                                id="aname"
                                name="aname"
                                required
                                placeholder="Enter full name">
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                Role <span class="text-red-600">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all" id="role" name="role" required>
                                <option value="">Select a role</option>
                                <?php foreach ($available_roles as $roleValue => $roleName): ?>
                                    <option value="<?= htmlspecialchars($roleValue) ?>">
                                        <?= \App\Core\Role::getIcon($roleValue) ?>
                                        <?= htmlspecialchars($roleName) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mt-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Role Permissions:</p>
                                <div class="space-y-1 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">👑 Super Admin</span>
                                        <span>- Full system access</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">⚡ Admin</span>
                                        <span>- Manage content & lower-level users</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">✏️ Editor</span>
                                        <span>- Manage all posts & comments</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">✍️ Author</span>
                                        <span>- Manage own posts only</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="aheadline" class="block text-sm font-medium text-gray-700 mb-2">
                                Headline
                            </label>
                            <input type="text"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                                id="aheadline"
                                name="aheadline"
                                placeholder="e.g., Senior Editor, Content Writer">
                        </div>

                        <div>
                            <label for="abio" class="block text-sm font-medium text-gray-700 mb-2">
                                Bio
                            </label>
                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                                id="abio"
                                name="abio"
                                rows="4"
                                placeholder="Enter a short bio"></textarea>
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-200">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i> Create Admin
                            </button>
                            <a href="/admin/admins"
                                class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden sticky top-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-info-circle mr-2"></i>Role Hierarchy
                    </h2>
                </div>
                <div class="p-6">
                    <p class="font-semibold text-gray-900 mb-4">Understanding Roles:</p>

                    <div class="space-y-4">
                        <div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 mb-2">
                                👑 Super Administrator
                            </span>
                            <ul class="mt-2 space-y-1 text-sm text-gray-600 ml-4">
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-600 mr-2 mt-0.5"></i>
                                    <span>Full system control</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-600 mr-2 mt-0.5"></i>
                                    <span>Manage all users and roles</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-600 mr-2 mt-0.5"></i>
                                    <span>Access to all features</span>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 mb-2">
                                ⚡ Administrator
                            </span>
                            <ul class="mt-2 space-y-1 text-sm text-gray-600 ml-4">
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-600 mr-2 mt-0.5"></i>
                                    <span>Manage content & categories</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-600 mr-2 mt-0.5"></i>
                                    <span>Manage Editors & Authors</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-600 mr-2 mt-0.5"></i>
                                    <span>Cannot manage Super Admins</span>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 mb-2">
                                ✏️ Editor
                            </span>
                            <ul class="mt-2 space-y-1 text-sm text-gray-600 ml-4">
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-600 mr-2 mt-0.5"></i>
                                    <span>Manage all posts</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-600 mr-2 mt-0.5"></i>
                                    <span>Approve/manage comments</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-600 mr-2 mt-0.5"></i>
                                    <span>Cannot manage users</span>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 mb-2">
                                ✍️ Author
                            </span>
                            <ul class="mt-2 space-y-1 text-sm text-gray-600 ml-4">
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-600 mr-2 mt-0.5"></i>
                                    <span>Create own posts</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-600 mr-2 mt-0.5"></i>
                                    <span>Edit own posts</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-600 mr-2 mt-0.5"></i>
                                    <span>Limited access</span>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-3 rounded-lg mt-4">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle mr-2 mt-0.5"></i>
                                <p class="text-sm">You can only assign roles lower than your own.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>