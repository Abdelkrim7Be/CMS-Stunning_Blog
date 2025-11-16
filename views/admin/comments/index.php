<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manage Comments</h1>
            <p class="text-gray-600 mt-1">Moderate and manage user comments</p>
        </div>
    </div>

    <!-- Comments Table -->
    <?php if (empty($comments)): ?>
        <div class="bg-white rounded-xl shadow-lg p-16 text-center border border-gray-200">
            <i class="fas fa-comments text-7xl text-gray-300 mb-6"></i>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">No Comments Yet</h3>
            <p class="text-gray-600">Comments from readers will appear here</p>
        </div>
    <?php else: ?>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">

            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-comments mr-2"></i>All Comments
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Post</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Comment</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($comments as $comment): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #<?= htmlspecialchars($comment['id']) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 max-w-xs truncate">
                                        <?= htmlspecialchars($comment['post_title'] ?? 'N/A') ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold mr-3">
                                            <?= strtoupper(substr($comment['name'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($comment['name']) ?>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <?= htmlspecialchars($comment['email']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 max-w-md">
                                        <?= htmlspecialchars(substr($comment['comment'], 0, 80)) ?>...
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($comment['status'] === 'ON'): ?>
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i> Approved
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> Pending
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <i class="far fa-calendar mr-1"></i>
                                    <?= date('M d, Y', strtotime($comment['datetime'])) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <?php if ($comment['status'] === 'OFF'): ?>
                                        <form action="/admin/comments/<?= $comment['id'] ?>/approve" method="POST" style="display: inline;">
                                            <button
                                                type="submit"
                                                class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                                                title="Approve Comment">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form action="/admin/comments/<?= $comment['id'] ?>/disapprove" method="POST" style="display: inline;">
                                            <button
                                                type="submit"
                                                class="inline-flex items-center px-3 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors"
                                                title="Unapprove Comment">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <form action="/admin/comments/<?= $comment['id'] ?>/delete" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                        <button
                                            type="submit"
                                            class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                                            title="Delete Comment">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Total: <span class="font-semibold text-gray-900"><?= count($comments) ?></span> comments
                    </p>
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>