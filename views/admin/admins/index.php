<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manage Admins</h1>
            <p class="text-gray-600 mt-1">Create, edit, and manage administrator accounts</p>
        </div>
        <?php if (\App\Core\Session::can('manage_admins')): ?>
            <a
                href="/admin/admins/create"
                class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-user-plus mr-2"></i> Add New Admin
            </a>
        <?php endif; ?>
    </div>

    <!-- Admins Table Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">

        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-users-cog mr-2"></i>All Administrators
            </h2>
        </div>

        <div class="overflow-x-auto">
            <?php if (empty($admins)): ?>
                <div class="text-center py-16">
                    <i class="fas fa-user-slash text-7xl text-gray-300 mb-4"></i>
                    <p class="text-xl text-gray-500 mb-2">No admins found</p>
                    <p class="text-gray-400 mb-6">Get started by creating your first admin</p>
                    <?php if (\App\Core\Session::can('manage_admins')): ?>
                        <a
                            href="/admin/admins/create"
                            class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                            <i class="fas fa-user-plus mr-2"></i> Create Your First Admin
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Avatar</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Username</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Full Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Headline</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Added By</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        $currentUserId = \App\Core\Session::userId();
                        $currentUserRole = \App\Core\Session::role();
                        foreach ($admins as $admin):
                            $canManage = \App\Core\Role::isHigherThan($currentUserRole, $admin['role'] ?? 'author');
                        ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?= htmlspecialchars($admin['id']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if (!empty($admin['aimage'])): ?>
                                        <img src="/assets/images/<?= htmlspecialchars($admin['aimage']) ?>"
                                            alt="Avatar"
                                            class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                                    <?php else: ?>
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-black to-gray-800 text-white flex items-center justify-center text-lg font-bold border-2 border-gray-200">
                                            <?= strtoupper(substr($admin['username'], 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <strong class="text-gray-900"><?= htmlspecialchars($admin['username']) ?></strong>
                                    <?php if ($currentUserId && $currentUserId == $admin['id']): ?>
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            You
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <?= htmlspecialchars($admin['aname'] ?? 'N/A') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?= \App\Core\Role::getBadgeClass($admin['role'] ?? 'author') ?>">
                                        <?= \App\Core\Role::getIcon($admin['role'] ?? 'author') ?>
                                        <?= \App\Core\Role::getName($admin['role'] ?? 'author') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <?= htmlspecialchars($admin['aheadline'] ?? 'N/A') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?= htmlspecialchars($admin['added_by'] ?? 'N/A') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?= htmlspecialchars($admin['datetime']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <?php if ($canManage && (!$currentUserId || $currentUserId != $admin['id'])): ?>
                                        <div class="flex items-center gap-2">
                                            <a href="/admin/admins/<?= $admin['id'] ?>/edit"
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="/admin/admins/<?= $admin['id'] ?>/delete"
                                                method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                                                    title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    <?php elseif ($currentUserId == $admin['id']): ?>
                                        <span class="text-gray-500 text-xs">
                                            <i class="fas fa-lock"></i> Your account
                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-500 text-xs">
                                            <i class="fas fa-ban"></i> Protected
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <?php if (isset($totalPages) && $totalPages > 1): ?>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <!-- Info -->
                            <p class="text-sm text-gray-600">
                                Page <span class="font-semibold text-gray-900"><?= $currentPage ?></span> of
                                <span class="font-semibold text-gray-900"><?= $totalPages ?></span>
                            </p>

                            <!-- Pagination Controls -->
                            <div class="flex items-center space-x-2">
                                <!-- Previous Button -->
                                <?php if ($currentPage > 1): ?>
                                    <a href="/admin/admins?page=<?= $currentPage - 1 ?>"
                                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                                        <i class="fas fa-chevron-left mr-1"></i> Previous
                                    </a>
                                <?php else: ?>
                                    <span class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-400 text-sm font-medium cursor-not-allowed">
                                        <i class="fas fa-chevron-left mr-1"></i> Previous
                                    </span>
                                <?php endif; ?>

                                <!-- Page Numbers -->
                                <div class="hidden sm:flex items-center space-x-1">
                                    <?php
                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($totalPages, $currentPage + 2);

                                    if ($startPage > 1): ?>
                                        <a href="/admin/admins?page=1" class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm">1</a>
                                        <?php if ($startPage > 2): ?>
                                            <span class="px-2 text-gray-500">...</span>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                        <a href="/admin/admins?page=<?= $i ?>"
                                            class="px-3 py-2 <?= $i === $currentPage ? 'bg-black text-white' : 'bg-white hover:bg-gray-50' ?> border border-gray-300 rounded-lg transition-colors text-sm font-medium">
                                            <?= $i ?>
                                        </a>
                                    <?php endfor; ?>

                                    <?php if ($endPage < $totalPages): ?>
                                        <?php if ($endPage < $totalPages - 1): ?>
                                            <span class="px-2 text-gray-500">...</span>
                                        <?php endif; ?>
                                        <a href="/admin/admins?page=<?= $totalPages ?>" class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm"><?= $totalPages ?></a>
                                    <?php endif; ?>
                                </div>

                                <!-- Next Button -->
                                <?php if ($currentPage < $totalPages): ?>
                                    <a href="/admin/admins?page=<?= $currentPage + 1 ?>"
                                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                                        Next <i class="fas fa-chevron-right ml-1"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-400 text-sm font-medium cursor-not-allowed">
                                        Next <i class="fas fa-chevron-right ml-1"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
        </div>
    <?php endif; ?>
    </div>
</div>
</div>