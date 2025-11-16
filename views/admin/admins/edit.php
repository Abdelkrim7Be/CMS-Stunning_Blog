<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Admin</h1>
        <a href="/admin/admins" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Admins
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Admin Information</h6>
                </div>
                <div class="card-body">
                    <form action="/admin/admins/<?= $admin['id'] ?>" method="POST">
                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control"
                                id="username"
                                name="username"
                                required
                                value="<?= htmlspecialchars($admin['username']) ?>"
                                placeholder="Enter username">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                minlength="4"
                                placeholder="Leave blank to keep current password">
                            <small class="form-text text-muted">Only fill if you want to change the password</small>
                        </div>

                        <div class="form-group">
                            <label for="aname">Full Name <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control"
                                id="aname"
                                name="aname"
                                required
                                value="<?= htmlspecialchars($admin['aname']) ?>"
                                placeholder="Enter full name">
                        </div>

                        <div class="form-group">
                            <label for="role">Role <span class="text-danger">*</span></label>
                            <select class="form-control" id="role" name="role" required>
                                <?php foreach ($available_roles as $roleValue => $roleName): ?>
                                    <option value="<?= htmlspecialchars($roleValue) ?>"
                                        <?= ($admin['role'] ?? 'author') === $roleValue ? 'selected' : '' ?>>
                                        <?= \App\Core\Role::getIcon($roleValue) ?>
                                        <?= htmlspecialchars($roleName) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">
                                Current role:
                                <span class="badge <?= \App\Core\Role::getBadgeClass($admin['role'] ?? 'author') ?>">
                                    <?= \App\Core\Role::getIcon($admin['role'] ?? 'author') ?>
                                    <?= \App\Core\Role::getName($admin['role'] ?? 'author') ?>
                                </span>
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="aheadline">Headline</label>
                            <input type="text"
                                class="form-control"
                                id="aheadline"
                                name="aheadline"
                                value="<?= htmlspecialchars($admin['aheadline'] ?? '') ?>"
                                placeholder="e.g., Senior Editor, Content Writer">
                        </div>

                        <div class="form-group">
                            <label for="abio">Bio</label>
                            <textarea class="form-control"
                                id="abio"
                                name="abio"
                                rows="4"
                                placeholder="Enter a short bio"><?= htmlspecialchars($admin['abio'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Admin
                            </button>
                            <a href="/admin/admins" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user"></i> Admin Details
                    </h6>
                </div>
                <div class="card-body">
                    <p><strong>ID:</strong> <?= htmlspecialchars($admin['id']) ?></p>
                    <p><strong>Created:</strong> <?= htmlspecialchars($admin['datetime']) ?></p>
                    <p><strong>Added By:</strong> <?= htmlspecialchars($admin['added_by'] ?? 'N/A') ?></p>
                    <p><strong>Current Role:</strong>
                        <span class="badge <?= \App\Core\Role::getBadgeClass($admin['role'] ?? 'author') ?>">
                            <?= \App\Core\Role::getIcon($admin['role'] ?? 'author') ?>
                            <?= \App\Core\Role::getName($admin['role'] ?? 'author') ?>
                        </span>
                    </p>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-exclamation-triangle"></i> Danger Zone
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Delete this admin permanently</p>
                    <form action="/admin/admins/<?= $admin['id'] ?>/delete"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this admin? This action cannot be undone!');">
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-trash"></i> Delete Admin
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>