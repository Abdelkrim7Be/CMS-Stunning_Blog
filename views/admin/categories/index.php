<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manage Categories</h1>
            <p class="text-gray-600 mt-1">Organize your content with categories</p>
        </div>
        <a
            href="/admin/categories/create"
            class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-plus mr-2"></i> Create New Category
        </a>
    </div>

    <!-- Categories Grid -->
    <?php if (empty($categories)): ?>
        <div class="bg-white rounded-xl shadow-lg p-16 text-center border border-gray-200">
            <i class="fas fa-folder-open text-7xl text-gray-300 mb-6"></i>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">No Categories Found</h3>
            <p class="text-gray-600 mb-6">Create your first category to organize your posts</p>
            <a
                href="/admin/categories/create"
                class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                <i class="fas fa-plus mr-2"></i> Create Your First Category
            </a>
        </div>
    <?php else: ?>

        <!-- Categories Table -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">

            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-folder mr-2"></i>All Categories
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Category Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Created By</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($categories as $category): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #<?= htmlspecialchars($category['id']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-black text-white">
                                        <i class="fas fa-tag mr-2"></i>
                                        <?= htmlspecialchars($category['title']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <i class="fas fa-user mr-1"></i>
                                    <?= htmlspecialchars($category['author']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <i class="far fa-calendar mr-1"></i>
                                    <?= date('M d, Y', strtotime($category['datetime'])) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <form
                                        action="/admin/categories/<?= $category['id'] ?>/delete"
                                        method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this category? This will affect all posts in this category.');">
                                        <button
                                            type="submit"
                                            class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                                            title="Delete Category">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <!-- Info -->
                        <p class="text-sm text-gray-600">
                            Showing <span class="font-semibold text-gray-900"><?= count($categories) ?></span> of
                            <span class="font-semibold text-gray-900"><?= $totalCategories ?? 0 ?></span> categories
                        </p>

                        <!-- Pagination Controls -->
                        <?php if (isset($totalPages) && $totalPages > 1): ?>
                            <div class="flex items-center space-x-2">
                                <!-- Previous Button -->
                                <?php if ($currentPage > 1): ?>
                                    <a href="/admin/categories?page=<?= $currentPage - 1 ?>"
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
                                        <a href="/admin/categories?page=1" class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm">1</a>
                                        <?php if ($startPage > 2): ?>
                                            <span class="px-2 text-gray-500">...</span>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                        <a href="/admin/categories?page=<?= $i ?>"
                                            class="px-3 py-2 <?= $i === $currentPage ? 'bg-black text-white' : 'bg-white hover:bg-gray-50' ?> border border-gray-300 rounded-lg transition-colors text-sm font-medium">
                                            <?= $i ?>
                                        </a>
                                    <?php endfor; ?>

                                    <?php if ($endPage < $totalPages): ?>
                                        <?php if ($endPage < $totalPages - 1): ?>
                                            <span class="px-2 text-gray-500">...</span>
                                        <?php endif; ?>
                                        <a href="/admin/categories?page=<?= $totalPages ?>" class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm"><?= $totalPages ?></a>
                                    <?php endif; ?>
                                </div>

                                <!-- Next Button -->
                                <?php if ($currentPage < $totalPages): ?>
                                    <a href="/admin/categories?page=<?= $currentPage + 1 ?>"
                                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                                        Next <i class="fas fa-chevron-right ml-1"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-400 text-sm font-medium cursor-not-allowed">
                                        Next <i class="fas fa-chevron-right ml-1"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>
</div>
</div>
</div>