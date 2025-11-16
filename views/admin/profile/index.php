<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">My Profile</h1>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <?php if (!empty($profile['aimage'])): ?>
                        <img src="/assets/images/<?= htmlspecialchars($profile['aimage']) ?>"
                            alt="Avatar"
                            class="img-fluid rounded-circle mb-3"
                            style="width: 150px; height: 150px; object-fit: cover;">
                    <?php else: ?>
                        <div style="width: 150px; height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; font-weight: bold; margin: 0 auto 1rem;">
                            <?= strtoupper(substr($profile['username'], 0, 1)) ?>
                        </div>
                    <?php endif; ?>

                    <h4><?= htmlspecialchars($profile['username']) ?></h4>

                    <?php if (!empty($profile['aheadline'])): ?>
                        <p class="text-muted"><?= htmlspecialchars($profile['aheadline']) ?></p>
                    <?php endif; ?>

                    <hr>

                    <div class="text-left">
                        <p class="mb-2">
                            <strong>Full Name:</strong><br>
                            <?= htmlspecialchars($profile['aname'] ?? 'Not set') ?>
                        </p>
                        <p class="mb-2">
                            <strong>Member Since:</strong><br>
                            <small><?= htmlspecialchars($profile['datetime']) ?></small>
                        </p>
                        <p class="mb-0">
                            <strong>Added By:</strong><br>
                            <small><?= htmlspecialchars($profile['added_by'] ?? 'N/A') ?></small>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
                </div>
                <div class="card-body">
                    <form action="/admin/profile" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="username">Username *</label>
                            <input type="text"
                                class="form-control"
                                id="username"
                                value="<?= htmlspecialchars($profile['username']) ?>"
                                disabled>
                            <small class="form-text text-muted">Username cannot be changed</small>
                        </div>

                        <div class="form-group">
                            <label for="aname">Full Name</label>
                            <input type="text"
                                class="form-control"
                                id="aname"
                                name="aname"
                                value="<?= htmlspecialchars($profile['aname'] ?? '') ?>"
                                placeholder="Enter your full name">
                        </div>

                        <div class="form-group">
                            <label for="aheadline">Headline</label>
                            <input type="text"
                                class="form-control"
                                id="aheadline"
                                name="aheadline"
                                value="<?= htmlspecialchars($profile['aheadline'] ?? '') ?>"
                                placeholder="e.g., Web Developer, Content Manager">
                        </div>

                        <div class="form-group">
                            <label for="abio">Bio</label>
                            <textarea class="form-control"
                                id="abio"
                                name="abio"
                                rows="4"
                                placeholder="Tell us about yourself..."><?= htmlspecialchars($profile['abio'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="aimage">Avatar Image</label>
                            <input type="file"
                                class="form-control-file"
                                id="aimage"
                                name="aimage"
                                accept="image/*">
                            <small class="form-text text-muted">
                                Leave empty to keep current avatar. Accepted formats: JPG, PNG, GIF
                            </small>
                        </div>

                        <hr>

                        <h6 class="font-weight-bold text-primary mb-3">Change Password</h6>

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                placeholder="Leave empty to keep current password">
                            <small class="form-text text-muted">
                                Only fill this if you want to change your password
                            </small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                            <a href="/admin/dashboard" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>