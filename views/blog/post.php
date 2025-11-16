<!-- Single Post View -->
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <!-- Post Header -->
        <article class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <!-- Featured Image -->
            <?php if (!empty($post['image'])): ?>
                <div class="relative h-96 overflow-hidden">
                    <img src="/uploads/<?= htmlspecialchars($post['image']) ?>"
                        alt="<?= htmlspecialchars($post['title']) ?>"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                </div>
            <?php endif; ?>

            <!-- Post Content -->
            <div class="p-8 md:p-12">
                <!-- Title -->
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight" style="font-family: 'Playfair Display', serif;">
                    <?= htmlspecialchars($post['title']) ?>
                </h1>

                <!-- Meta Information -->
                <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600 mb-8 pb-8 border-b border-gray-200">
                    <div class="flex items-center">
                        <i class="fas fa-user mr-2 text-gray-400"></i>
                        <span>By <strong><?= htmlspecialchars($post['author']) ?></strong></span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar mr-2 text-gray-400"></i>
                        <span><?= date('F j, Y', strtotime($post['datetime'])) ?></span>
                    </div>
                    <?php if (!empty($post['category'])): ?>
                        <div class="flex items-center">
                            <i class="fas fa-folder mr-2 text-gray-400"></i>
                            <a href="/?category=<?= urlencode($post['category']) ?>"
                                class="text-gray-900 hover:text-black font-medium transition-colors">
                                <?= htmlspecialchars($post['category']) ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Post Body -->
                <div class="prose prose-lg max-w-none">
                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                </div>

                <!-- Tags (if available) -->
                <?php if (!empty($post['tags'])): ?>
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <div class="flex items-center flex-wrap gap-2">
                            <i class="fas fa-tags text-gray-400"></i>
                            <?php
                            $tags = explode(',', $post['tags']);
                            foreach ($tags as $tag):
                                $tag = trim($tag);
                            ?>
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full hover:bg-gray-200 transition-colors">
                                    <?= htmlspecialchars($tag) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </article>

        <!-- Comments Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8 md:p-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-8" style="font-family: 'Playfair Display', serif;">
                    <i class="fas fa-comments mr-3 text-gray-400"></i>
                    Comments
                </h2>

                <!-- Comment Form -->
                <div class="mb-12" x-data="{ submitted: false }">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Leave a Comment</h3>

                    <?php if (isset($_GET['comment_success'])): ?>
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                            <i class="fas fa-check-circle mr-2"></i>
                            Your comment has been submitted and is awaiting approval.
                        </div>
                    <?php endif; ?>

                    <form action="/post/<?= $post['id'] ?>" method="POST" class="space-y-4"
                        @submit="submitted = true">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    id="name"
                                    name="name"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                                    placeholder="Your name">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email"
                                    id="email"
                                    name="email"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                                    placeholder="your@email.com">
                            </div>
                        </div>
                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                                Comment <span class="text-red-500">*</span>
                            </label>
                            <textarea id="comment"
                                name="comment"
                                rows="5"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all resize-none"
                                placeholder="Share your thoughts..."></textarea>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-8 py-3 bg-black text-white font-semibold rounded-lg hover:bg-gray-800 transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="submitted">
                            <i class="fas fa-paper-plane mr-2"></i>
                            <span x-show="!submitted">Submit Comment</span>
                            <span x-show="submitted">Submitting...</span>
                        </button>
                    </form>
                </div>

                <!-- Comments List -->
                <?php
                $comments = \App\Models\Comment::byPost($post['id']);
                ?>

                <?php if (!empty($comments)): ?>
                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">
                            <?= count($comments) ?> Comment<?= count($comments) !== 1 ? 's' : '' ?>
                        </h3>

                        <?php foreach ($comments as $comment): ?>
                            <div class="border-l-4 border-gray-200 pl-6 py-4 hover:border-black transition-colors">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="text-gray-600 font-bold text-sm">
                                                <?= strtoupper(substr($comment['name'], 0, 1)) ?>
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900"><?= htmlspecialchars($comment['name']) ?></p>
                                            <p class="text-sm text-gray-500">
                                                <i class="far fa-clock mr-1"></i>
                                                <?= date('F j, Y', strtotime($comment['datetime'])) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700 leading-relaxed ml-13">
                                    <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12 text-gray-500">
                        <i class="fas fa-comments text-6xl mb-4 text-gray-300"></i>
                        <p class="text-lg">No comments yet. Be the first to share your thoughts!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Back to Blog -->
        <div class="mt-8 text-center">
            <a href="/" class="inline-flex items-center text-gray-600 hover:text-black transition-colors group">
                <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                Back to Blog
            </a>
        </div>
    </div>
</div>