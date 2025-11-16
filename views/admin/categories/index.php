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

                <!-- Stats Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Total: <span class="font-semibold text-gray-900"><?= count($categories) ?></span> categories
                    </p>
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>
</div>
</div>
</div>