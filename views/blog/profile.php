<!-- Author Profile View -->
<div class="container mx-auto px-4 py-12">
    <div class="max-w-6xl mx-auto">

        <!-- Author Header Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-12">
            <div class="h-48 bg-gradient-to-r from-black to-gray-800"></div>
            <div class="px-8 md:px-12 pb-12">
                <div class="flex flex-col md:flex-row md:items-end md:space-x-8 -mt-20">
                    <!-- Avatar -->
                    <div class="flex-shrink-0 mb-6 md:mb-0">
                        <div class="w-40 h-40 rounded-2xl overflow-hidden border-4 border-white shadow-xl bg-white">
                            <?php if (!empty($author['aimage']) && $author['aimage'] !== 'avatar.jpg'): ?>
                                <img src="/uploads/<?= htmlspecialchars($author['aimage']) ?>"
                                    alt="<?= htmlspecialchars($author['aname']) ?>"
                                    class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                    <span class="text-6xl font-bold text-gray-400">
                                        <?= strtoupper(substr($author['aname'], 0, 1)) ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Author Info -->
                    <div class="flex-grow">
                        <h1 class="text-4xl font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">
                            <?= htmlspecialchars($author['aname']) ?>
                        </h1>
                        <?php if (!empty($author['aheadline'])): ?>
                            <p class="text-xl text-gray-600 mb-4">
                                <?= htmlspecialchars($author['aheadline']) ?>
                            </p>
                        <?php endif; ?>
                        <div class="flex items-center space-x-6 text-sm text-gray-500">
                            <span>
                                <i class="fas fa-user mr-2"></i>
                                @<?= htmlspecialchars($author['username']) ?>
                            </span>
                            <span>
                                <i class="fas fa-file-alt mr-2"></i>
                                <?= count($posts) ?> Post<?= count($posts) !== 1 ? 's' : '' ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Bio -->
                <?php if (!empty($author['abio'])): ?>
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">
                            <i class="fas fa-info-circle mr-2 text-gray-400"></i>
                            About
                        </h3>
                        <p class="text-gray-700 leading-relaxed">
                            <?= nl2br(htmlspecialchars($author['abio'])) ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Posts Section -->
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-8" style="font-family: 'Playfair Display', serif;">
                <i class="fas fa-file-alt mr-3 text-gray-400"></i>
                Posts by <?= htmlspecialchars($author['aname']) ?>
            </h2>

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

                                <!-- Category Badge -->
                                <?php if (!empty($post['category_name'])): ?>
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 bg-black text-white text-xs font-bold uppercase tracking-wider rounded-full">
                                            <?= htmlspecialchars($post['category_name']) ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
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
                                    <?= htmlspecialchars(substr($post['post'], 0, 150)) ?>...
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
                                    <i class="fas fa-comments mr-1"></i>
                                    <?= \App\Models\Post::getApprovedCommentsCount($post['id']) ?> Comments
                                </span>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-lg p-16 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                        <i class="fas fa-inbox text-5xl text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">No Posts Yet</h3>
                    <p class="text-gray-600 mb-8">This author hasn't published any posts yet.</p>
                    <a href="/" class="inline-flex items-center px-6 py-3 bg-black text-white font-semibold rounded-lg hover:bg-gray-800 transition-all">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to All Posts
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Back to Blog -->
        <div class="mt-12 text-center">
            <a href="/" class="inline-flex items-center text-gray-600 hover:text-black transition-colors group">
                <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                Back to All Posts
            </a>
        </div>

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