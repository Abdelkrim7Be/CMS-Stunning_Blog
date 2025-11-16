<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create New Post</h1>
            <p class="text-gray-600 mt-1">Write and publish a new blog post</p>
        </div>
        <a href="/admin/posts" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-arrow-left mr-2"></i> Back to Posts
        </a>
    </div>

    <!-- Create Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-plus-circle mr-2"></i>Post Details
            </h2>
        </div>

        <div class="p-8">
            <form action="/admin/posts" method="POST" enctype="multipart/form-data" class="space-y-6">

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Post Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                        id="title"
                        name="title"
                        required
                        placeholder="Enter post title">
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                        id="category"
                        name="category"
                        required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['title']) ?>">
                                <?= htmlspecialchars($cat['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Featured Image -->
                <div>
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                        Featured Image
                    </label>
                    <input type="file"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                        id="image"
                        name="image"
                        accept="image/*">
                    <p class="mt-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Accepted: JPG, PNG, GIF. Max: 2MB
                    </p>
                </div>

                <!-- Post Content -->
                <div>
                    <label for="post" class="block text-sm font-semibold text-gray-700 mb-2">
                        Post Content <span class="text-red-500">*</span>
                    </label>
                    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all resize-none"
                        id="post"
                        name="post"
                        rows="15"
                        required
                        placeholder="Write your post content here..."></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="inline-flex items-center px-8 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i> Create Post
                    </button>
                    <a href="/admin/posts" class="inline-flex items-center px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all">
                        <i class="fas fa-times mr-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>