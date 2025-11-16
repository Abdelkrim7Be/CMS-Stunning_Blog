<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Post</h1>
        <a href="/admin/posts" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Posts
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="/admin/posts/<?= $post['id'] ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Post Title *</label>
                    <input type="text"
                        class="form-control"
                        id="title"
                        name="title"
                        required
                        value="<?= htmlspecialchars($post['title']) ?>">
                </div>

                <div class="form-group">
                    <label for="category">Category *</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['id']) ?>"
                                <?= $post['category'] == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Featured Image</label>
                    <?php if (!empty($post['image'])): ?>
                        <div class="mb-2">
                            <img src="/uploads/<?= htmlspecialchars($post['image']) ?>"
                                alt="Current image"
                                style="max-width: 200px; height: auto;">
                            <p class="text-muted small">Current image</p>
                        </div>
                    <?php endif; ?>
                    <input type="file"
                        class="form-control-file"
                        id="image"
                        name="image"
                        accept="image/*">
                    <small class="form-text text-muted">
                        Leave empty to keep current image. Accepted formats: JPG, PNG, GIF. Max size: 2MB
                    </small>
                </div>

                <div class="form-group">
                    <label for="post">Post Content *</label>
                    <textarea class="form-control"
                        id="post"
                        name="post"
                        rows="15"
                        required><?= htmlspecialchars($post['post']) ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Post
                    </button>
                    <a href="/admin/posts" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>