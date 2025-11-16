<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Posts</h1>
        <a href="/admin/posts/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Post
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Posts</h6>
        </div>
        <div class="card-body">
            <?php if (empty($posts)): ?>
                <p class="text-center text-muted">No posts found.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Date</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td><?= htmlspecialchars($post['id']) ?></td>
                                    <td>
                                        <img src="/uploads/<?= htmlspecialchars($post['image']) ?>"
                                            alt="Post image"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td><?= htmlspecialchars($post['title']) ?></td>
                                    <td>
                                        <span class="badge badge-info">
                                            <?= htmlspecialchars($post['category_name'] ?? $post['category']) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($post['author']) ?></td>
                                    <td><?= htmlspecialchars($post['datetime']) ?></td>
                                    <td>
                                        <a href="/admin/posts/<?= $post['id'] ?>/edit"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="/admin/posts/<?= $post['id'] ?>/delete"
                                            method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this post?');">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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