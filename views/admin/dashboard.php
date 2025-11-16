<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Total Posts</h6>
                    <h2 class="mb-0"><?= $stats['total_posts'] ?></h2>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Categories</h6>
                    <h2 class="mb-0"><?= $stats['total_categories'] ?></h2>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="fas fa-folder"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Comments</h6>
                    <h2 class="mb-0"><?= $stats['total_comments'] ?></h2>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="fas fa-comments"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Pending</h6>
                    <h2 class="mb-0"><?= $stats['pending_comments'] ?></h2>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Posts -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-file-alt"></i> Recent Posts</h5>
            </div>
            <div class="card-body">
                <?php if (empty($recent_posts)): ?>
                    <p class="text-muted">No posts yet.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_posts as $post): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($post['title']) ?></td>
                                        <td><span class="badge badge-primary"><?= htmlspecialchars($post['category_name'] ?? 'Uncategorized') ?></span></td>
                                        <td><?= date('M d, Y', strtotime($post['datetime'])) ?></td>
                                        <td>
                                            <a href="/admin/posts/<?= $post['id'] ?>/edit" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

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