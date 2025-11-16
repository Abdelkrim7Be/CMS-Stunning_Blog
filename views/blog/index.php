<!-- Blog Posts Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Categories Section -->
    <?php if (!$searchQuery && !$categoryFilter && !empty($categories)): ?>
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-th-large text-black mr-2"></i>
                    Explore Categories
                </h2>
                <span class="text-sm text-gray-500"><?= count($categories) ?> categories</span>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <?php foreach ($categories as $category): ?>
                    <?php
                    // Count posts in this category
                    $postCount = 0;
                    foreach (\App\Models\Post::all() as $p) {
                        if ($p['category'] === $category['title']) {
                            $postCount++;
                        }
                    }
                    ?>
                    <a href="/?category=<?= urlencode($category['title']) ?>"
                        class="group block bg-white border-2 border-gray-200 rounded-xl p-5 hover:border-black hover:shadow-lg transition-all duration-300">
                        <div class="flex flex-col items-center text-center">
                            <!-- Icon -->
                            <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-black group-hover:scale-110 transition-all duration-300">
                                <i class="fas fa-folder text-gray-600 text-xl group-hover:text-white transition-colors"></i>
                            </div>

                            <!-- Category Name -->
                            <h3 class="font-semibold text-gray-900 mb-2 text-sm group-hover:text-black">
                                <?= htmlspecialchars($category['title']) ?>
                            </h3>

                            <!-- Post Count -->
                            <div class="flex items-center space-x-1 text-xs text-gray-500">
                                <i class="fas fa-file-alt"></i>
                                <span><?= $postCount ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Divider -->
        <div class="relative mb-12">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="bg-gray-50 px-4 text-sm text-gray-500">Recent Articles</span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Search Results / Category Filter Notice -->
    <?php if ($searchQuery): ?>
        <div class="mb-8 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-search text-blue-500 mr-3"></i>
                <p class="text-blue-700">
                    Search results for: <strong>"<?= htmlspecialchars($searchQuery) ?>"</strong>
                    <a href="/" class="ml-4 text-blue-600 hover:text-blue-800 underline">Clear search</a>
                </p>
            </div>
        </div>
    <?php elseif ($categoryFilter): ?>
        <div class="mb-8 bg-purple-50 border-l-4 border-purple-500 p-4 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-folder text-purple-500 mr-3"></i>
                <p class="text-purple-700">
                    Filtering by category: <strong>"<?= htmlspecialchars($categoryFilter) ?>"</strong>
                    <a href="/" class="ml-4 text-purple-600 hover:text-purple-800 underline">View all posts</a>
                </p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Posts Grid -->
    <?php if (empty($posts)): ?>
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                <i class="fas fa-inbox text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No Posts Found</h3>
            <p class="text-gray-600 mb-6">
                <?php if ($searchQuery): ?>
                    No posts match your search. Try different keywords.
                <?php elseif ($categoryFilter): ?>
                    No posts in this category yet.
                <?php else: ?>
                    There are no published posts yet. Check back soon!
                <?php endif; ?>
            </p>
            <a href="/" class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                <i class="fas fa-home mr-2"></i> Back to Home
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($posts as $post): ?>
                <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 group">
                    <!-- Post Image -->
                    <a href="/post/<?= $post['id'] ?>" class="block relative overflow-hidden h-56">
                        <?php if (!empty($post['image'])): ?>
                            <img src="/uploads/<?= htmlspecialchars($post['image']) ?>"
                                alt="<?= htmlspecialchars($post['title']) ?>"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                                <i class="fas fa-image text-6xl text-gray-600"></i>
                            </div>
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>

                    <!-- Post Content -->
                    <div class="p-6">
                        <!-- Category & Date -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                            <?php if (!empty($post['category'])): ?>
                                <a href="/?category=<?= urlencode($post['category']) ?>"
                                    class="inline-flex items-center px-3 py-1 bg-black text-white text-xs font-medium rounded-full hover:bg-gray-800 transition-colors">
                                    <i class="fas fa-folder mr-1"></i>
                                    <?= htmlspecialchars($post['category']) ?>
                                </a>
                            <?php else: ?>
                                <span class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-700 text-xs font-medium rounded-full">
                                    <i class="fas fa-folder mr-1"></i> Uncategorized
                                </span>
                            <?php endif; ?>
                            <span class="text-xs">
                                <i class="fas fa-calendar mr-1"></i>
                                <?= date('M j, Y', strtotime($post['datetime'])) ?>
                            </span>
                        </div>

                        <!-- Post Title -->
                        <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 hover:text-gray-700 transition-colors">
                            <a href="/post/<?= $post['id'] ?>">
                                <?= htmlspecialchars($post['title']) ?>
                            </a>
                        </h2>

                        <!-- Post Excerpt -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            <?php
                            $excerpt = strip_tags($post['post']);
                            echo htmlspecialchars(mb_substr($excerpt, 0, 150));
                            if (mb_strlen($excerpt) > 150) echo '...';
                            ?>
                        </p>

                        <!-- Post Footer -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <!-- Author -->
                            <?php if (!empty($post['username'])): ?>
                                <a href="/profile?username=<?= urlencode($post['username']) ?>"
                                    class="flex items-center text-sm text-gray-600 hover:text-black transition-colors group">
                                    <div class="w-8 h-8 bg-black text-white rounded-full flex items-center justify-center mr-2 group-hover:bg-gray-800 transition-colors">
                                        <i class="fas fa-user text-xs"></i>
                                    </div>
                                    <span class="font-medium"><?= htmlspecialchars($post['author'] ?? 'Unknown') ?></span>
                                </a>
                            <?php else: ?>
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-8 h-8 bg-gray-300 text-white rounded-full flex items-center justify-center mr-2">
                                        <i class="fas fa-user text-xs"></i>
                                    </div>
                                    <span class="font-medium"><?= htmlspecialchars($post['author'] ?? 'Unknown') ?></span>
                                </div>
                            <?php endif; ?>

                            <!-- Comments Count -->
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-comments mr-1"></i>
                                <?php
                                $commentCount = \App\Models\Post::getApprovedCommentsCount($post['id']);
                                echo $commentCount;
                                ?>
                            </span>
                        </div>

                        <!-- Read More Button -->
                        <a href="/post/<?= $post['id'] ?>"
                            class="mt-4 inline-flex items-center text-black hover:text-gray-700 font-medium text-sm transition-colors group">
                            Read More
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="mt-12 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <!-- Previous Button -->
                    <?php if ($currentPage > 1): ?>
                        <a href="/?page=<?= $currentPage - 1 ?><?= $searchQuery ? '&search=' . urlencode($searchQuery) : '' ?><?= $categoryFilter ? '&category=' . urlencode($categoryFilter) : '' ?>"
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
                            <a href="/?page=1<?= $searchQuery ? '&search=' . urlencode($searchQuery) : '' ?><?= $categoryFilter ? '&category=' . urlencode($categoryFilter) : '' ?>"
                                class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm">1</a>
                            <?php if ($startPage > 2): ?>
                                <span class="px-2 text-gray-500">...</span>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <a href="/?page=<?= $i ?><?= $searchQuery ? '&search=' . urlencode($searchQuery) : '' ?><?= $categoryFilter ? '&category=' . urlencode($categoryFilter) : '' ?>"
                                class="px-3 py-2 <?= $i === $currentPage ? 'bg-black text-white' : 'bg-white hover:bg-gray-50' ?> border border-gray-300 rounded-lg transition-colors text-sm font-medium">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($endPage < $totalPages): ?>
                            <?php if ($endPage < $totalPages - 1): ?>
                                <span class="px-2 text-gray-500">...</span>
                            <?php endif; ?>
                            <a href="/?page=<?= $totalPages ?><?= $searchQuery ? '&search=' . urlencode($searchQuery) : '' ?><?= $categoryFilter ? '&category=' . urlencode($categoryFilter) : '' ?>"
                                class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm"><?= $totalPages ?></a>
                        <?php endif; ?>
                    </div>

                    <!-- Next Button -->
                    <?php if ($currentPage < $totalPages): ?>
                        <a href="/?page=<?= $currentPage + 1 ?><?= $searchQuery ? '&search=' . urlencode($searchQuery) : '' ?><?= $categoryFilter ? '&category=' . urlencode($categoryFilter) : '' ?>"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                            Next <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    <?php else: ?>
                        <span class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-400 text-sm font-medium cursor-not-allowed">
                            Next <i class="fas fa-chevron-right ml-1"></i>
                        </span>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- Tailwind Custom Styles -->
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>