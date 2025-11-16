<!-- Messages -->
<?php
if (isset($_SESSION['SuccessMessage'])) {
    echo '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">';
    echo '<div class="flex items-center">';
    echo '<i class="fas fa-check-circle text-2xl mr-3"></i>';
    echo '<p class="font-semibold">' . htmlentities($_SESSION['SuccessMessage']) . '</p>';
    echo '</div></div>';
    unset($_SESSION['SuccessMessage']);
}
if (isset($_SESSION['ErrorMessage'])) {
    echo '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">';
    echo '<div class="flex items-center">';
    echo '<i class="fas fa-exclamation-circle text-2xl mr-3"></i>';
    echo '<p class="font-semibold">' . htmlentities($_SESSION['ErrorMessage']) . '</p>';
    echo '</div></div>';
    unset($_SESSION['ErrorMessage']);
}
?>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

    <!-- Main Content Area -->
    <div class="lg:col-span-3">

        <!-- Posts Grid -->
        <?php if (empty($posts)): ?>
            <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-200">
                <i class="fas fa-search text-7xl text-gray-300 mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">No Posts Found</h3>
                <p class="text-gray-600 mb-6">No posts match your search criteria. Try a different search or browse all posts.</p>
                <a href="/" class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                    <i class="fas fa-home mr-2"></i>Back to Home
                </a>
            </div>
        <?php else: ?>

            <div class="space-y-8">
                <?php foreach ($posts as $post): ?>
                    <?php
                    $postId = $post['id'];
                    $dateTime = $post['datetime'];
                    $postTitle = $post['title'];
                    $category = $post['category'];
                    $author = $post['author'];
                    $image = $post['image'];
                    $postDescription = $post['post'];
                    $commentCount = \App\Models\Post::getApprovedCommentsCount($postId);
                    ?>

                    <article class="post-card bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-2xl">
                        <div class="grid md:grid-cols-5 gap-0">

                            <!-- Post Image -->
                            <div class="md:col-span-2 overflow-hidden">
                                <img
                                    src="/uploads/<?= htmlentities($image) ?>"
                                    alt="<?= htmlentities($postTitle) ?>"
                                    class="w-full h-64 md:h-full object-cover">
                            </div>

                            <!-- Post Content -->
                            <div class="md:col-span-3 p-8">
                                <div class="flex items-center space-x-3 mb-4">
                                    <span class="px-4 py-1 bg-black text-white text-xs font-bold uppercase tracking-wider rounded-full">
                                        <?= htmlentities($category) ?>
                                    </span>
                                    <span class="text-gray-500 text-sm">
                                        <i class="far fa-calendar"></i>
                                        <?= date('M d, Y', strtotime($dateTime)) ?>
                                    </span>
                                </div>

                                <h2 class="text-3xl font-bold text-gray-900 mb-4 hover:text-gray-700 transition-colors">
                                    <a href="/post/<?= $postId ?>">
                                        <?= htmlentities($postTitle) ?>
                                    </a>
                                </h2>

                                <div class="flex items-center space-x-4 mb-4 text-sm text-gray-600">
                                    <span>
                                        <i class="fas fa-user mr-1"></i>
                                        <a href="/profile?username=<?= htmlentities($author) ?>" class="hover:text-black transition-colors font-medium">
                                            <?= htmlentities($author) ?>
                                        </a>
                                    </span>
                                    <span>
                                        <i class="fas fa-comments mr-1"></i>
                                        <?= $commentCount ?> comments
                                    </span>
                                </div>

                                <p class="text-gray-700 leading-relaxed mb-6">
                                    <?php
                                    if (strlen($postDescription) > 200) {
                                        echo htmlentities(substr($postDescription, 0, 200)) . "...";
                                    } else {
                                        echo htmlentities($postDescription);
                                    }
                                    ?>
                                </p>

                                <a
                                    href="/post/<?= $postId ?>"
                                    class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-all shadow-md hover:shadow-lg">
                                    Read Full Article
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>

                        </div>
                    </article>

                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <nav class="mt-12">
                    <ul class="flex justify-center items-center space-x-2">

                        <!-- Previous Button -->
                        <?php if ($currentPage > 1): ?>
                            <li>
                                <a
                                    href="/?page=<?= $currentPage - 1 ?><?= isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?><?= isset($_GET['category']) ? '&category=' . urlencode($_GET['category']) : '' ?>"
                                    class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($totalPages, $currentPage + 2);

                        if ($startPage > 1): ?>
                            <li>
                                <a href="/?page=1" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">1</a>
                            </li>
                            <?php if ($startPage > 2): ?>
                                <li class="px-2 text-gray-500">...</li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <li>
                                <a
                                    href="/?page=<?= $i ?><?= isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?><?= isset($_GET['category']) ? '&category=' . urlencode($_GET['category']) : '' ?>"
                                    class="px-4 py-2 rounded-lg transition-colors <?= $i == $currentPage ? 'bg-black text-white' : 'bg-white border border-gray-300 hover:bg-gray-50' ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($endPage < $totalPages): ?>
                            <?php if ($endPage < $totalPages - 1): ?>
                                <li class="px-2 text-gray-500">...</li>
                            <?php endif; ?>
                            <li>
                                <a href="/?page=<?= $totalPages ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"><?= $totalPages ?></a>
                            </li>
                        <?php endif; ?>

                        <!-- Next Button -->
                        <?php if ($currentPage < $totalPages): ?>
                            <li>
                                <a
                                    href="/?page=<?= $currentPage + 1 ?><?= isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?><?= isset($_GET['category']) ? '&category=' . urlencode($_GET['category']) : '' ?>"
                                    class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
            <?php endif; ?>

        <?php endif; ?>

    </div>

    <!-- Sidebar -->
    <aside class="lg:col-span-1 space-y-8">

        <!-- Categories Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden sticky top-24">
            <div class="bg-black text-white px-6 py-4">
                <h3 class="text-xl font-bold">
                    <i class="fas fa-folder mr-2"></i>Categories
                </h3>
            </div>
            <div class="p-6">
                <?php if (!empty($categories)): ?>
                    <ul class="space-y-3">
                        <?php foreach ($categories as $cat): ?>
                            <li>
                                <a
                                    href="/?category=<?= htmlentities($cat['title']) ?>"
                                    class="flex items-center justify-between px-4 py-3 rounded-lg bg-gray-50 hover:bg-black hover:text-white transition-all group">
                                    <span class="font-medium">
                                        <i class="fas fa-tag mr-2 text-gray-400 group-hover:text-white"></i>
                                        <?= htmlentities($cat['title']) ?>
                                    </span>
                                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-white"></i>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-gray-500 text-center py-4">No categories available</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Newsletter Card -->
        <div class="bg-gradient-to-br from-gray-900 to-black text-white rounded-xl shadow-lg p-6">
            <div class="text-center">
                <i class="fas fa-envelope text-4xl mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Stay Updated</h3>
                <p class="text-gray-300 text-sm mb-4">
                    Subscribe to our newsletter for the latest posts
                </p>
                <form action="/?subscribe=true" method="POST" class="space-y-3" x-data="{ email: '', subscribed: false }">
                    <input
                        type="email"
                        name="newsletter_email"
                        placeholder="Your email..."
                        required
                        x-model="email"
                        class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white">
                    <button
                        type="submit"
                        @click="subscribed = true; setTimeout(() => subscribed = false, 3000)"
                        class="w-full px-4 py-2 bg-white text-black rounded-lg hover:bg-gray-200 transition-colors font-semibold">
                        <span x-show="!subscribed">Subscribe</span>
                        <span x-show="subscribed"><i class="fas fa-check mr-1"></i> Subscribed!</span>
                    </button>
                </form>
                <?php if (isset($_GET['subscribed'])): ?>
                    <p class="text-green-400 text-sm mt-2">
                        <i class="fas fa-check-circle"></i> Thanks for subscribing!
                    </p>
                <?php endif; ?>
            </div>
        </div>

    </aside>

</div>