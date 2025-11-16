<?php

use App\Core\Role;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">
                    <i class="fas fa-user-shield"></i> Assign Roles to Users
                </h1>
                <a href="/admin/roles" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Role Management
                </a>
            </div>

            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-<?= $_SESSION['flash_type'] ?? 'info' ?> alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['flash_message']) ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
            <?php endif; ?>

            <!-- Single User Role Assignment -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-tag"></i> Assign Role to User
                    </h5>
                </div>
                <div class="card-body">
                    <form action="/admin/roles/update-user-role" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_id">Select User *</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        <option value="">-- Choose User --</option>
                                        <?php foreach ($users as $user): ?>
                                            <option value="<?= $user['id'] ?>" data-current-role="<?= $user['role'] ?>">
                                                <?= htmlspecialchars($user['username']) ?>
                                                (<?= htmlspecialchars($user['aname']) ?>)
                                                - Current: <?= Role::getIcon($user['role']) ?> <?= Role::getName($user['role']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="role">New Role *</label>
                                    <select name="role" id="role" class="form-control" required>
                                        <option value="">-- Select Role --</option>
                                        <?php foreach ($available_roles as $roleKey => $roleName): ?>
                                            <option value="<?= $roleKey ?>">
                                                <?= Role::getIcon($roleKey) ?> <?= htmlspecialchars($roleName) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save"></i> Update Role
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bulk Role Assignment -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-users-cog"></i> Bulk Role Assignment
                    </h5>
                </div>
                <div class="card-body">
                    <form action="/admin/roles/bulk-assign" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label>Select Users</label>
                                <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                    <?php foreach ($users as $user): ?>
                                        <div class="custom-control custom-checkbox mb-2">
                                            <input
                                                type="checkbox"
                                                class="custom-control-input"
                                                id="user_<?= $user['id'] ?>"
                                                name="user_ids[]"
                                                value="<?= $user['id'] ?>">
                                            <label class="custom-control-label" for="user_<?= $user['id'] ?>">
                                                <strong><?= htmlspecialchars($user['username']) ?></strong>
                                                (<?= htmlspecialchars($user['aname']) ?>)
                                                <span class="badge <?= Role::getBadgeClass($user['role']) ?>">
                                                    <?= Role::getIcon($user['role']) ?> <?= Role::getName($user['role']) ?>
                                                </span>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label>Assign Role</label>
                                <select name="role" class="form-control mb-3" required>
                                    <option value="">-- Select Role --</option>
                                    <?php foreach ($available_roles as $roleKey => $roleName): ?>
                                        <option value="<?= $roleKey ?>">
                                            <?= Role::getIcon($roleKey) ?> <?= htmlspecialchars($roleName) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <button type="submit" class="btn btn-info btn-block">
                                    <i class="fas fa-users"></i> Assign to Selected Users
                                </button>

                                <button type="button" class="btn btn-outline-secondary btn-block mt-2" onclick="selectAll()">
                                    <i class="fas fa-check-square"></i> Select All
                                </button>

                                <button type="button" class="btn btn-outline-secondary btn-block" onclick="deselectAll()">
                                    <i class="fas fa-square"></i> Deselect All
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- User Statistics by Role -->
            <div class="row mt-4">
                <div class="col-12">
                    <h4 class="mb-3">Users by Role</h4>
                </div>

                <?php
                $roleStats = [];
                foreach ($users as $user) {
                    $roleStats[$user['role']] = ($roleStats[$user['role']] ?? 0) + 1;
                }
                ?>

                <?php foreach (Role::all() as $roleKey => $roleName): ?>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h2 class="display-4"><?= Role::getIcon($roleKey) ?></h2>
                                <h5 class="card-title"><?= $roleName ?></h5>
                                <p class="display-4 mb-0"><?= $roleStats[$roleKey] ?? 0 ?></p>
                                <small class="text-muted">users</small>
                                <div class="mt-2">
                                    <a href="/admin/roles/users/<?= $roleKey ?>" class="btn btn-sm btn-outline-primary">
                                        View Users
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function selectAll() {
        document.querySelectorAll('input[name="user_ids[]"]').forEach(cb => cb.checked = true);
    }

    function deselectAll() {
        document.querySelectorAll('input[name="user_ids[]"]').forEach(cb => cb.checked = false);
    }
</script>