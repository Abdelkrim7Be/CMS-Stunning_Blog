<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- Total Posts Card -->
    <div class="stat-card bg-gradient-to-br from-black to-gray-800 text-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-300 text-sm font-medium uppercase tracking-wide">Total Posts</p>
                    <h3 class="text-4xl font-bold mt-2"><?= $stats['total_posts'] ?></h3>
                    <p class="text-gray-400 text-xs mt-2">
                        <i class="fas fa-arrow-up text-green-400"></i> All published posts
                    </p>
                </div>
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-alt text-3xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-black/20 px-6 py-3">
            <a href="/admin/posts" class="text-white text-sm hover:text-gray-300 transition-colors">
                View all posts <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>

    <!-- Total Categories Card -->
    <div class="stat-card bg-gradient-to-br from-gray-800 to-gray-700 text-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-300 text-sm font-medium uppercase tracking-wide">Categories</p>
                    <h3 class="text-4xl font-bold mt-2"><?= $stats['total_categories'] ?></h3>
                    <p class="text-gray-400 text-xs mt-2">
                        <i class="fas fa-layer-group text-blue-400"></i> Active categories
                    </p>
                </div>
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-folder text-3xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-black/20 px-6 py-3">
            <a href="/admin/categories" class="text-white text-sm hover:text-gray-300 transition-colors">
                Manage categories <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>

    <!-- Total Comments Card -->
    <div class="stat-card bg-gradient-to-br from-gray-700 to-gray-600 text-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-300 text-sm font-medium uppercase tracking-wide">Comments</p>
                    <h3 class="text-4xl font-bold mt-2"><?= $stats['total_comments'] ?></h3>
                    <p class="text-gray-400 text-xs mt-2">
                        <i class="fas fa-comments text-purple-400"></i> Total feedback
                    </p>
                </div>
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-comments text-3xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-black/20 px-6 py-3">
            <a href="/admin/comments" class="text-white text-sm hover:text-gray-300 transition-colors">
                View comments <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>

    <!-- Pending Comments Card -->
    <div class="stat-card bg-gradient-to-br from-gray-600 to-gray-500 text-white rounded-xl shadow-lg overflow-hidden relative">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-300 text-sm font-medium uppercase tracking-wide">Pending</p>
                    <h3 class="text-4xl font-bold mt-2"><?= $stats['pending_comments'] ?></h3>
                    <p class="text-gray-400 text-xs mt-2">
                        <i class="fas fa-clock text-yellow-400"></i> Awaiting review
                    </p>
                </div>
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-hourglass-half text-3xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-black/20 px-6 py-3">
            <a href="/admin/comments?status=pending" class="text-white text-sm hover:text-gray-300 transition-colors">
                Review now <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <?php if ($stats['pending_comments'] > 0): ?>
            <div class="absolute top-4 right-4">
                <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse">
                    <?= $stats['pending_comments'] ?>
                </span>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    <!-- Posts & Comments Trend -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-chart-line text-black mr-2"></i>
                Content Trend
            </h2>
            <span class="text-sm text-gray-500">Last 6 months</span>
        </div>
        <div class="h-64">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    <!-- Posts by Category -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-chart-pie text-black mr-2"></i>
                Posts by Category
            </h2>
            <span class="text-sm text-gray-500">Distribution</span>
        </div>
        <div class="h-64">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

</div>

<!-- Recent Activity Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Recent Posts -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-file-alt text-black mr-2"></i>
                Recent Posts
            </h2>
        </div>
        <div class="p-6">
            <?php if (empty($recent_posts)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">No posts yet. Create your first post!</p>
                    <a href="/admin/posts/create" class="inline-block mt-4 px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Create Post
                    </a>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($recent_posts as $post): ?>
                        <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-gray-50 transition-colors border border-gray-100">
                            <img
                                src="/uploads/<?= htmlspecialchars($post['image']) ?>"
                                alt="Post thumbnail"
                                class="w-20 h-20 rounded-lg object-cover">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 truncate">
                                    <?= htmlspecialchars($post['title']) ?>
                                </h3>
                                <div class="flex items-center space-x-3 mt-2 text-sm text-gray-600">
                                    <span class="px-2 py-1 bg-black text-white rounded text-xs">
                                        <?= htmlspecialchars($post['category_name'] ?? 'Uncategorized') ?>
                                    </span>
                                    <span>
                                        <i class="far fa-calendar"></i>
                                        <?= date('M d, Y', strtotime($post['datetime'])) ?>
                                    </span>
                                </div>
                            </div>
                            <a
                                href="/admin/posts/<?= $post['id'] ?>/edit"
                                class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-black transition-colors text-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-6 text-center">
                    <a href="/admin/posts" class="text-black hover:text-gray-700 font-medium">
                        View all posts <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pending Comments -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-clock text-black mr-2"></i>
                Pending Comments
            </h2>
        </div>
        <div class="p-6">
            <?php if (empty($pending_comments)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-check-circle text-5xl text-green-500 mb-3"></i>
                    <p class="text-gray-500 text-sm">All caught up!</p>
                </div>
            <?php else: ?>
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    <?php foreach (array_slice($pending_comments, 0, 5) as $comment): ?>
                        <div class="p-4 rounded-lg border border-gray-200 hover:border-black transition-colors">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold">
                                    <?= strtoupper(substr($comment['name'], 0, 1)) ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm text-gray-900">
                                        <?= htmlspecialchars($comment['name']) ?>
                                    </p>
                                    <p class="text-xs text-gray-600 mt-1 line-clamp-2">
                                        <?= htmlspecialchars(substr($comment['comment'], 0, 80)) ?>...
                                    </p>
                                    <div class="flex items-center space-x-2 mt-3">
                                        <a
                                            href="/admin/comments?approve=<?= $comment['id'] ?>"
                                            class="px-3 py-1 bg-black text-white rounded text-xs hover:bg-gray-800 transition-colors">
                                            <i class="fas fa-check"></i> Approve
                                        </a>
                                        <a
                                            href="/admin/comments?delete=<?= $comment['id'] ?>"
                                            class="px-3 py-1 bg-gray-200 text-gray-700 rounded text-xs hover:bg-gray-300 transition-colors">
                                            <i class="fas fa-times"></i> Reject
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 text-center">
                    <a href="/admin/comments" class="text-black hover:text-gray-700 font-medium text-sm">
                        View all <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<!-- Chart.js Scripts -->
<script>
    // Prepare data
    const postsData = <?= json_encode($analytics['posts_by_month'] ?? []) ?>;
    const commentsData = <?= json_encode($analytics['comments_by_month'] ?? []) ?>;
    const categoryData = <?= json_encode($analytics['posts_by_category'] ?? []) ?>;

    // Trend Chart
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: postsData.map(d => {
                const date = new Date(d.month + '-01');
                return date.toLocaleDateString('en-US', {
                    month: 'short',
                    year: 'numeric'
                });
            }),
            datasets: [{
                    label: 'Posts',
                    data: postsData.map(d => d.count),
                    borderColor: '#000000',
                    backgroundColor: 'rgba(0, 0, 0, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3
                },
                {
                    label: 'Comments',
                    data: commentsData.map(d => d.count),
                    borderColor: '#666666',
                    backgroundColor: 'rgba(102, 102, 102, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: '#000',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f0f0f0'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const colors = ['#000000', '#333333', '#666666', '#999999', '#cccccc'];

    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: categoryData.map(d => d.name),
            datasets: [{
                data: categoryData.map(d => d.count),
                backgroundColor: colors.slice(0, categoryData.length),
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: '#000',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    }
                }
            }
        }
    });
</script>

<!-- Pending Comments -->
<div class="col-md-4 mb-4">
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-clock"></i> Pending Comments</h5>
        </div>
        <div class="card-body">
            <?php if (empty($pending_comments)): ?>
                <p class="text-muted">No pending comments.</p>
            <?php else: ?>
                <div style="max-height: 400px; overflow-y: auto;">
                    <?php foreach ($pending_comments as $comment): ?>
                        <div class="border-bottom pb-2 mb-2">
                            <strong><?= htmlspecialchars($comment['name']) ?></strong>
                            <p class="mb-1 small text-muted"><?= htmlspecialchars(substr($comment['comment'], 0, 100)) ?>...</p>
                            <small class="text-muted">
                                <i class="far fa-clock"></i> <?= date('M d', strtotime($comment['datetime'])) ?>
                            </small>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="/admin/comments" class="btn btn-sm btn-primary btn-block mt-3">
                    View All Comments
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>