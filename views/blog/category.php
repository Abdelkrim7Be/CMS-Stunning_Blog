<!-- Category View -->
<div class="container mx-auto px-4 py-12">
    <!-- Category Header -->
    <div class="max-w-6xl mx-auto mb-12">
        <div class="bg-gradient-to-r from-black to-gray-800 rounded-2xl shadow-xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 rounded-full mb-6">
                <i class="fas fa-folder text-4xl text-white"></i>
            </div>
            <h1 class="text-5xl font-bold text-white mb-4" style="font-family: 'Playfair Display', serif;">
                <?= htmlspecialchars($category['title']) ?>
            </h1>
            <?php if (!empty($category['description'])): ?>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    <?= htmlspecialchars($category['description']) ?>
                </p>
            <?php endif; ?>
            <div class="mt-6 text-gray-400">
                <i class="fas fa-file-alt mr-2"></i>
                <?= count($posts) ?> Post<?= count($posts) !== 1 ? 's' : '' ?>
            </div>
        </div>
    </div>

    <!-- Posts Grid -->
    <div class="max-w-6xl mx-auto">
        <?php if (!empty($posts)): ?>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($posts as $post): ?>
                    <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                        <!-- Post Image -->
                        <div class="relative h-56 overflow-hidden bg-gray-200">
                            <?php if (!empty($post['image'])): ?>
                                <img src="/uploads/<?= htmlspecialchars($post['image']) ?>"
                                    alt="<?= htmlspecialchars($post['title']) ?>"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                    <i class="fas fa-image text-6xl text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>

                        <!-- Post Content -->
                        <div class="p-6">
                            <!-- Meta -->
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <i class="far fa-calendar mr-2"></i>
                                <?= date('M j, Y', strtotime($post['datetime'])) ?>
                            </div>

                            <!-- Title -->
                            <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-gray-700 transition-colors">
                                <a href="/post/<?= $post['id'] ?>">
                                    <?= htmlspecialchars($post['title']) ?>
                                </a>
                            </h2>

                            <!-- Excerpt -->
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                <?= htmlspecialchars(substr($post['content'], 0, 150)) ?>...
                            </p>

                            <!-- Read More -->
                            <a href="/post/<?= $post['id'] ?>"
                                class="inline-flex items-center text-black font-semibold hover:underline group">
                                Read More
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>

                        <!-- Post Footer -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
                            <span>
                                <i class="fas fa-user mr-1"></i>
                                <?= htmlspecialchars($post['author']) ?>
                            </span>
                            <?php
                            $postId = $post['id'];
                            $commentCount = \App\Models\Post::getApprovedCommentsCount($postId);
                            ?>
                            <span>
                                <i class="fas fa-comments mr-1"></i>
                                <?= $commentCount ?>
                            </span>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                    <i class="fas fa-inbox text-5xl text-gray-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">No Posts Found</h3>
                <p class="text-gray-600 mb-8">There are no posts in this category yet.</p>
                <a href="/" class="inline-flex items-center px-6 py-3 bg-black text-white font-semibold rounded-lg hover:bg-gray-800 transition-all">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to All Posts
                </a>
            </div>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if (!empty($posts) && isset($totalPages) && $totalPages > 1): ?>
            <div class="mt-12 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <!-- Previous Button -->
                    <?php if ($currentPage > 1): ?>
                        <a href="/category/<?= $category['id'] ?>?page=<?= $currentPage - 1 ?>"
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
                            <a href="/category/<?= $category['id'] ?>?page=1" class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm">1</a>
                            <?php if ($startPage > 2): ?>
                                <span class="px-2 text-gray-500">...</span>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <a href="/category/<?= $category['id'] ?>?page=<?= $i ?>"
                                class="px-3 py-2 <?= $i === $currentPage ? 'bg-black text-white' : 'bg-white hover:bg-gray-50' ?> border border-gray-300 rounded-lg transition-colors text-sm font-medium">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($endPage < $totalPages): ?>
                            <?php if ($endPage < $totalPages - 1): ?>
                                <span class="px-2 text-gray-500">...</span>
                            <?php endif; ?>
                            <a href="/category/<?= $category['id'] ?>?page=<?= $totalPages ?>" class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm"><?= $totalPages ?></a>
                        <?php endif; ?>
                    </div>

                    <!-- Next Button -->
                    <?php if ($currentPage < $totalPages): ?>
                        <a href="/category/<?= $category['id'] ?>?page=<?= $currentPage + 1 ?>"
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

        <!-- Back to Blog -->
        <?php if (!empty($posts)): ?>
            <div class="mt-12 text-center">
                <a href="/" class="inline-flex items-center text-gray-600 hover:text-black transition-colors group">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                    Back to All Posts
                </a>
            </div>
        <?php endif; ?>
    </div>
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