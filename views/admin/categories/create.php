<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create New Category</h1>
            <p class="text-gray-600 mt-1">Add a new category to organize your posts</p>
        </div>
        <a href="/admin/categories" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-arrow-left mr-2"></i> Back to Categories
        </a>
    </div>

    <!-- Create Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden max-w-2xl">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-folder-plus mr-2"></i>Category Details
            </h2>
        </div>

        <div class="p-8">
            <form action="/admin/categories" method="POST" class="space-y-6">

                <!-- Category Name -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                        id="title"
                        name="title"
                        required
                        placeholder="e.g., Technology, Sports, News">
                    <p class="mt-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Choose a descriptive name for this category
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="inline-flex items-center px-8 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i> Create Category
                    </button>
                    <a href="/admin/categories" class="inline-flex items-center px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all">
                        <i class="fas fa-times mr-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>