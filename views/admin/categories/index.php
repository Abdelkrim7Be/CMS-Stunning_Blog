<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Categories</h1>
        <a href="/admin/categories/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Category
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Categories</h6>
        </div>
        <div class="card-body">
            <?php if (empty($categories)): ?>
                <p class="text-center text-muted">No categories found.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="80">ID</th>
                                <th>Category Name</th>
                                <th>Created By</th>
                                <th>Date</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= htmlspecialchars($category['id']) ?></td>
                                    <td>
                                        <span class="badge badge-info badge-lg">
                                            <?= htmlspecialchars($category['title']) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($category['author']) ?></td>
                                    <td><?= htmlspecialchars($category['datetime']) ?></td>
                                    <td>
                                        <form action="/admin/categories/<?= $category['id'] ?>/delete"
                                            method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this category? This will affect all posts in this category.');">
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