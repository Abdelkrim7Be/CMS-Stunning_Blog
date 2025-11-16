<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Comments</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Comments</h6>
        </div>
        <div class="card-body">
            <?php if (empty($comments)): ?>
                <p class="text-center text-muted">No comments found.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Post</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>Approved By</th>
                                <th>Date</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($comments as $comment): ?>
                                <tr>
                                    <td><?= htmlspecialchars($comment['id']) ?></td>
                                    <td>
                                        <small><?= htmlspecialchars($comment['post_title'] ?? 'N/A') ?></small>
                                    </td>
                                    <td><?= htmlspecialchars($comment['name']) ?></td>
                                    <td>
                                        <small><?= htmlspecialchars($comment['email']) ?></small>
                                    </td>
                                    <td>
                                        <small><?= htmlspecialchars(substr($comment['comment'], 0, 50)) ?>...</small>
                                    </td>
                                    <td>
                                        <?php if ($comment['status'] === 'ON'): ?>
                                            <span class="badge badge-success">Approved</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small><?= htmlspecialchars($comment['approvedby']) ?></small>
                                    </td>
                                    <td>
                                        <small><?= htmlspecialchars($comment['datetime']) ?></small>
                                    </td>
                                    <td>
                                        <?php if ($comment['status'] === 'OFF'): ?>
                                            <form action="/admin/comments/<?= $comment['id'] ?>/approve"
                                                method="POST"
                                                style="display: inline;">
                                                <button type="submit"
                                                    class="btn btn-sm btn-success"
                                                    title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <form action="/admin/comments/<?= $comment['id'] ?>/disapprove"
                                                method="POST"
                                                style="display: inline;">
                                                <button type="submit"
                                                    class="btn btn-sm btn-warning"
                                                    title="Disapprove">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <form action="/admin/comments/<?= $comment['id'] ?>/delete"
                                            method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
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