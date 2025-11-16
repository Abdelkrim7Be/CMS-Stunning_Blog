<!-- Search Results Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-search mr-3"></i>Search Results
            </h1>
            <?php if (!empty($query)): ?>
                <p class="text-gray-600 mt-2">
                    Showing results for: <span class="font-semibold">"<?= htmlspecialchars($query) ?>"</span>
                </p>
            <?php endif; ?>
        </div>
        <a href="/admin/dashboard" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>
</div>

<?php if (empty($query)): ?>
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-200">
        <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Search Query</h3>
        <p class="text-gray-600">Please enter a search term in the search bar above.</p>
    </div>
<?php else: ?>
    <!-- Results Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Posts Found</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?= count($results['posts']) ?></p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Categories Found</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?= count($results['categories']) ?></p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-folder text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Comments Found</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?= count($results['comments']) ?></p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-comments text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Results -->
    <?php if (!empty($results['posts'])): ?>
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-file-alt text-blue-600 mr-2"></i>
                    Posts (<?= count($results['posts']) ?>)
                </h2>
            </div>
            <div class="divide-y divide-gray-200">
                <?php foreach ($results['posts'] as $post): ?>
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 mb-2">
                                    <?= htmlspecialchars($post['title']) ?>
                                </h3>
                                <p class="text-sm text-gray-600 mb-3">
                                    <?= htmlspecialchars(substr(strip_tags($post['excerpt']), 0, 150)) ?>...
                                </p>
                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                    <span><i class="far fa-calendar mr-1"></i><?= htmlspecialchars($post['datetime']) ?></span>
                                    <span><i class="far fa-user mr-1"></i><?= htmlspecialchars($post['author']) ?></span>
                                    <span><i class="far fa-folder mr-1"></i><?= htmlspecialchars($post['category']) ?></span>
                                </div>
                            </div>
                            <div class="ml-4 flex space-x-2">
                                <a href="/admin/posts/<?= $post['id'] ?>/edit"
                                    class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors text-sm">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <a href="/post/<?= $post['id'] ?>"
                                    target="_blank"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm">
                                    <i class="fas fa-external-link-alt mr-1"></i>View
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Categories Results -->
    <?php if (!empty($results['categories'])): ?>
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-folder text-green-600 mr-2"></i>
                    Categories (<?= count($results['categories']) ?>)
                </h2>
            </div>
            <div class="divide-y divide-gray-200">
                <?php foreach ($results['categories'] as $category): ?>
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">
                                    <?= htmlspecialchars($category['title']) ?>
                                </h3>
                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                    <span><i class="far fa-calendar mr-1"></i><?= htmlspecialchars($category['datetime']) ?></span>
                                    <span><i class="far fa-user mr-1"></i><?= htmlspecialchars($category['author']) ?></span>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="/admin/categories"
                                    class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors text-sm">
                                    <i class="fas fa-eye mr-1"></i>View All
                                </a>
                                <a href="/category/<?= urlencode($category['title']) ?>"
                                    target="_blank"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm">
                                    <i class="fas fa-external-link-alt mr-1"></i>View
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Comments Results -->
    <?php if (!empty($results['comments'])): ?>
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-comments text-yellow-600 mr-2"></i>
                    Comments (<?= count($results['comments']) ?>)
                </h2>
            </div>
            <div class="divide-y divide-gray-200">
                <?php foreach ($results['comments'] as $comment): ?>
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="font-semibold text-gray-900">
                                        <?= htmlspecialchars($comment['name']) ?>
                                    </h3>
                                    <?php if ($comment['status'] === 'ON'): ?>
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded">
                                            Approved
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded">
                                            Pending
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-sm text-gray-600 mb-3">
                                    <?= htmlspecialchars(substr($comment['comment'], 0, 200)) ?><?= strlen($comment['comment']) > 200 ? '...' : '' ?>
                                </p>
                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                    <span><i class="far fa-calendar mr-1"></i><?= htmlspecialchars($comment['datetime']) ?></span>
                                    <span><i class="far fa-envelope mr-1"></i><?= htmlspecialchars($comment['email']) ?></span>
                                    <?php if (!empty($comment['post_title'])): ?>
                                        <span><i class="far fa-file-alt mr-1"></i><?= htmlspecialchars($comment['post_title']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="ml-4">
                                <a href="/admin/comments"
                                    class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors text-sm">
                                    <i class="fas fa-eye mr-1"></i>View All
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- No Results -->
    <?php if (empty($results['posts']) && empty($results['categories']) && empty($results['comments'])): ?>
        <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-200">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Results Found</h3>
            <p class="text-gray-600">
                We couldn't find anything matching "<?= htmlspecialchars($query) ?>".
                Try searching with different keywords.
            </p>
        </div>
    <?php endif; ?>
<?php endif; ?>