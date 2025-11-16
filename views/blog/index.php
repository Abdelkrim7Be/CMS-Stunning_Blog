<!-- Hero Section -->
<div class="hero">
    <div class="container text-center">
        <h1 class="display-4"><i class="fas fa-blog"></i> Welcome to Stunning Blog</h1>
        <p class="lead">Discover amazing articles, tutorials, and insights</p>
    </div>
</div>

<div class="container">
    <div class="row">
        <?php if (empty($posts)): ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <h4><i class="fas fa-info-circle"></i> No Posts Yet</h4>
                    <p class="mb-0">There are no published posts yet. Check back soon!</p>
                    <?php if (isAuth()): ?>
                        <a href="/admin/posts/create" class="btn btn-primary mt-3">Create Your First Post</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="col-md-4 mb-4">
                    <div class="card post-card">
                        <?php if ($post['image']): ?>
                            <img src="/uploads/<?= e($post['image']) ?>" class="card-img-top post-image" alt="<?= e($post['title']) ?>">
                        <?php else: ?>
                            <div class="card-img-top post-image bg-secondary d-flex align-items-center justify-content-center">
                                <i class="fas fa-image fa-3x text-white"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="/post/<?= $post['id'] ?>" class="text-dark text-decoration-none">
                                    <?= e($post['title']) ?>
                                </a>
                            </h5>
                            <p class="card-text text-muted">
                                <?= truncate(strip_tags($post['post']), 150) ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="far fa-calendar"></i> <?= formatDate($post['datetime'], 'M d, Y') ?>
                                </small>
                                <?php if ($post['category_name']): ?>
                                    <span class="badge badge-primary"><?= e($post['category_name']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>