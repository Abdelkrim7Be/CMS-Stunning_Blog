<div class="space-y-6">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
        <p class="text-gray-600 mt-1">Manage your account settings and information</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="p-8 text-center">
                    <!-- Avatar -->
                    <div class="mb-6">
                        <?php if (!empty($profile['aimage']) && $profile['aimage'] !== 'avatar.jpg'): ?>
                            <img src="/uploads/<?= htmlspecialchars($profile['aimage']) ?>"
                                alt="Avatar"
                                class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gray-100 shadow-lg">
                        <?php else: ?>
                            <div class="w-32 h-32 bg-gradient-to-br from-black to-gray-700 rounded-full mx-auto flex items-center justify-center text-white text-5xl font-bold shadow-lg">
                                <?= strtoupper(substr($profile['username'], 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Username -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">
                        <?= htmlspecialchars($profile['username']) ?>
                    </h3>

                    <!-- Headline -->
                    <?php if (!empty($profile['aheadline'])): ?>
                        <p class="text-gray-600 mb-6"><?= htmlspecialchars($profile['aheadline']) ?></p>
                    <?php else: ?>
                        <p class="text-gray-400 italic mb-6">No headline set</p>
                    <?php endif; ?>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-6"></div>

                    <!-- Profile Info -->
                    <div class="space-y-4 text-left">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Full Name</p>
                            <p class="text-gray-900 font-medium"><?= htmlspecialchars($profile['aname'] ?? 'Not set') ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Member Since</p>
                            <p class="text-gray-900 font-medium text-sm"><?= htmlspecialchars($profile['datetime']) ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Added By</p>
                            <p class="text-gray-900 font-medium"><?= htmlspecialchars($profile['added_by'] ?? 'N/A') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-user-edit mr-2"></i>Edit Profile
                    </h2>
                </div>

                <div class="p-8">
                    <form action="/admin/profile" method="POST" enctype="multipart/form-data" class="space-y-6">

                        <!-- Username (Read-only) -->
                        <div>
                            <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                                Username
                            </label>
                            <input type="text"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed"
                                id="username"
                                value="<?= htmlspecialchars($profile['username']) ?>"
                                disabled>
                            <p class="mt-2 text-sm text-gray-500">
                                <i class="fas fa-lock mr-1"></i>Username cannot be changed
                            </p>
                        </div>

                        <!-- Full Name -->
                        <div>
                            <label for="aname" class="block text-sm font-semibold text-gray-700 mb-2">
                                Full Name
                            </label>
                            <input type="text"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                                id="aname"
                                name="aname"
                                value="<?= htmlspecialchars($profile['aname'] ?? '') ?>"
                                placeholder="Enter your full name">
                        </div>

                        <!-- Headline -->
                        <div>
                            <label for="aheadline" class="block text-sm font-semibold text-gray-700 mb-2">
                                Headline
                            </label>
                            <input type="text"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                                id="aheadline"
                                name="aheadline"
                                value="<?= htmlspecialchars($profile['aheadline'] ?? '') ?>"
                                placeholder="e.g., Web Developer, Content Manager">
                        </div>

                        <!-- Bio -->
                        <div>
                            <label for="abio" class="block text-sm font-semibold text-gray-700 mb-2">
                                Bio
                            </label>
                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all resize-none"
                                id="abio"
                                name="abio"
                                rows="4"
                                placeholder="Tell us about yourself..."><?= htmlspecialchars($profile['abio'] ?? '') ?></textarea>
                        </div>

                        <!-- Avatar Image -->
                        <div>
                            <label for="aimage" class="block text-sm font-semibold text-gray-700 mb-2">
                                Avatar Image
                            </label>
                            <input type="file"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                                id="aimage"
                                name="aimage"
                                accept="image/*">
                            <p class="mt-2 text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Leave empty to keep current avatar. Accepted: JPG, PNG, GIF
                            </p>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 my-8"></div>

                        <!-- Password Section -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">
                                <i class="fas fa-key mr-2"></i>Change Password
                            </h3>
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    New Password
                                </label>
                                <input type="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition-all"
                                    id="password"
                                    name="password"
                                    placeholder="Leave empty to keep current password">
                                <p class="mt-2 text-sm text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Only fill this if you want to change your password
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i> Update Profile
                            </button>
                            <a href="/admin/dashboard" class="inline-flex items-center px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all">
                                <i class="fas fa-times mr-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>