<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Admins</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Administrators</h6>
        </div>
        <div class="card-body">
            <?php if (empty($admins)): ?>
                <p class="text-center text-muted">No admins found.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th width="80">Avatar</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Headline</th>
                                <th>Bio</th>
                                <th>Added By</th>
                                <th>Date</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $currentUserId = \App\Core\Session::userId();
                            foreach ($admins as $admin):
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($admin['id']) ?></td>
                                    <td>
                                        <?php if (!empty($admin['aimage'])): ?>
                                            <img src="/assets/images/<?= htmlspecialchars($admin['aimage']) ?>"
                                                alt="Avatar"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                        <?php else: ?>
                                            <div style="width: 50px; height: 50px; background: #667eea; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                <?= strtoupper(substr($admin['username'], 0, 1)) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($admin['username']) ?></strong>
                                        <?php if ($currentUserId && $currentUserId == $admin['id']): ?>
                                            <span class="badge badge-primary">You</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($admin['aname'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($admin['aheadline'] ?? 'N/A') ?></td>
                                    <td>
                                        <small><?= htmlspecialchars(substr($admin['abio'] ?? '', 0, 50)) ?></small>
                                    </td>
                                    <td><?= htmlspecialchars($admin['added_by'] ?? 'N/A') ?></td>
                                    <td>
                                        <small><?= htmlspecialchars($admin['datetime']) ?></small>
                                    </td>
                                    <td>
                                        <?php if (!$currentUserId || $currentUserId != $admin['id']): ?>
                                            <form action="/admin/admins/<?= $admin['id'] ?>/delete"
                                                method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-secondary" disabled title="Cannot delete yourself">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        <?php endif; ?>
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