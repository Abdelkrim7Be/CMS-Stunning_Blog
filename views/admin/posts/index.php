<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manage Posts</h1>
            <p class="text-gray-600 mt-1">Create, edit, and manage your blog posts</p>
        </div>
        <a
            href="/admin/posts/create"
            class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-plus mr-2"></i> Create New Post
        </a>
    </div>

    <!-- Posts Table Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">

        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <h2 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-file-alt mr-2"></i>All Posts
                </h2>

                <!-- Search and Filter -->
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input
                            type="text"
                            placeholder="Search posts..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                            onkeyup="filterTable(this.value)">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <?php if (empty($posts)): ?>
                <div class="text-center py-16">
                    <i class="fas fa-inbox text-7xl text-gray-300 mb-4"></i>
                    <p class="text-xl text-gray-500 mb-2">No posts found</p>
                    <p class="text-gray-400 mb-6">Get started by creating your first post</p>
                    <a
                        href="/admin/posts/create"
                        class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                        <i class="fas fa-plus mr-2"></i> Create Your First Post
                    </a>
                </div>
            <?php else: ?>
                <table class="w-full" id="postsTable">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($posts as $post): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #<?= htmlspecialchars($post['id']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img
                                        src="/uploads/<?= htmlspecialchars($post['image']) ?>"
                                        alt="Post image"
                                        class="w-16 h-16 rounded-lg object-cover shadow-md">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 max-w-md truncate">
                                        <?= htmlspecialchars($post['title']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-black text-white">
                                        <?= htmlspecialchars($post['category_name'] ?? $post['category']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?= htmlspecialchars($post['author']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <i class="far fa-calendar mr-1"></i>
                                    <?= date('M d, Y', strtotime($post['datetime'])) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <a
                                        href="/admin/posts/<?= $post['id'] ?>/edit"
                                        class="inline-flex items-center px-3 py-2 bg-gray-900 text-white rounded-lg hover:bg-black transition-colors"
                                        title="Edit Post">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form
                                        action="/admin/posts/<?= $post['id'] ?>/delete"
                                        method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this post? This action cannot be undone.');">
                                        <button
                                            type="submit"
                                            class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                                            title="Delete Post">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination Info -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Showing <span class="font-semibold text-gray-900"><?= count($posts) ?></span> posts
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<script>
    function filterTable(searchValue) {
        const table = document.getElementById('postsTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        searchValue = searchValue.toLowerCase();

        for (let i = 0; i < rows.length; i++) {
            const titleCell = rows[i].getElementsByTagName('td')[2];
            const categoryCell = rows[i].getElementsByTagName('td')[3];
            const authorCell = rows[i].getElementsByTagName('td')[4];

            if (titleCell || categoryCell || authorCell) {
                const titleText = titleCell.textContent || titleCell.innerText;
                const categoryText = categoryCell.textContent || categoryCell.innerText;
                const authorText = authorCell.textContent || authorCell.innerText;

                if (titleText.toLowerCase().indexOf(searchValue) > -1 ||
                    categoryText.toLowerCase().indexOf(searchValue) > -1 ||
                    authorText.toLowerCase().indexOf(searchValue) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }
</script>