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
                                    <!-- View Button -->
                                    <button
                                        onclick="openCommentModal(<?= htmlspecialchars(json_encode($comment), ENT_QUOTES, 'UTF-8') ?>)"
                                        class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                        title="View Full Comment">
                                        <i class="fas fa-eye"></i>
                                    </button>

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

                <!-- Pagination -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <!-- Info -->
                        <p class="text-sm text-gray-600">
                            Showing <span class="font-semibold text-gray-900"><?= count($comments) ?></span> of
                            <span class="font-semibold text-gray-900"><?= $totalComments ?? 0 ?></span> comments
                        </p>

                        <!-- Pagination Controls -->
                        <?php if (isset($totalPages) && $totalPages > 1): ?>
                            <div class="flex items-center space-x-2">
                                <!-- Previous Button -->
                                <?php if ($currentPage > 1): ?>
                                    <a href="/admin/comments?page=<?= $currentPage - 1 ?>"
                                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                                        <i class="fas fa-chevron-left mr-1"></i> Previous
                                    </a>
                                <?php else: ?>
                                    <span class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-400 text-sm font-medium cursor-not-allowed">
                                        <i class="fas fa-chevron-left mr-1"></i> Previous
                                    </span>
                                <?php endif; ?>

                                <!-- Page Numbers -->
                                <div class="hidden sm:flex items-center space-x-1">
                                    <?php
                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($totalPages, $currentPage + 2);

                                    if ($startPage > 1): ?>
                                        <a href="/admin/comments?page=1" class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm">1</a>
                                        <?php if ($startPage > 2): ?>
                                            <span class="px-2 text-gray-500">...</span>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                        <a href="/admin/comments?page=<?= $i ?>"
                                            class="px-3 py-2 <?= $i === $currentPage ? 'bg-black text-white' : 'bg-white hover:bg-gray-50' ?> border border-gray-300 rounded-lg transition-colors text-sm font-medium">
                                            <?= $i ?>
                                        </a>
                                    <?php endfor; ?>

                                    <?php if ($endPage < $totalPages): ?>
                                        <?php if ($endPage < $totalPages - 1): ?>
                                            <span class="px-2 text-gray-500">...</span>
                                        <?php endif; ?>
                                        <a href="/admin/comments?page=<?= $totalPages ?>" class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm"><?= $totalPages ?></a>
                                    <?php endif; ?>
                                </div>

                                <!-- Next Button -->
                                <?php if ($currentPage < $totalPages): ?>
                                    <a href="/admin/comments?page=<?= $currentPage + 1 ?>"
                                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                                        Next <i class="fas fa-chevron-right ml-1"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-400 text-sm font-medium cursor-not-allowed">
                                        Next <i class="fas fa-chevron-right ml-1"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>

<!-- Comment View Modal -->
<div id="commentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4" onclick="closeCommentModal(event)">
    <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-700 px-6 py-4 flex items-center justify-between">
            <h3 class="text-xl font-bold text-white">
                <i class="fas fa-comment-alt mr-2"></i>
                Comment Details
            </h3>
            <button onclick="closeCommentModal()" class="text-white hover:text-gray-300 transition-colors">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
            <!-- User Info -->
            <div class="mb-6 pb-6 border-b border-gray-200">
                <div class="flex items-center space-x-4 mb-4">
                    <div id="modalAvatar" class="w-16 h-16 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold text-2xl"></div>
                    <div class="flex-1">
                        <h4 id="modalName" class="text-lg font-bold text-gray-900"></h4>
                        <p id="modalEmail" class="text-sm text-gray-600"></p>
                    </div>
                    <div id="modalStatus"></div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Comment ID:</span>
                        <span id="modalId" class="font-semibold text-gray-900 ml-2"></span>
                    </div>
                    <div>
                        <span class="text-gray-500">Date:</span>
                        <span id="modalDate" class="font-semibold text-gray-900 ml-2"></span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-500">Post:</span>
                        <span id="modalPost" class="font-semibold text-gray-900 ml-2"></span>
                    </div>
                </div>
            </div>

            <!-- Comment Text -->
            <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200">
                <h5 class="text-sm font-bold text-gray-700 mb-3 flex items-center">
                    <i class="fas fa-quote-left text-gray-400 mr-2"></i>
                    Comment Message:
                </h5>
                <p id="modalComment" class="text-gray-800 leading-relaxed whitespace-pre-wrap"></p>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3 border-t border-gray-200">
            <button onclick="closeCommentModal()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                Close
            </button>
            <button id="modalApproveBtn" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                <i class="fas fa-check mr-2"></i>Approve
            </button>
            <button id="modalDisapproveBtn" class="px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors font-medium">
                <i class="fas fa-ban mr-2"></i>Unapprove
            </button>
            <button id="modalDeleteBtn" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                <i class="fas fa-trash mr-2"></i>Delete
            </button>
        </div>
    </div>
</div>

<script>
    let currentComment = null;

    function openCommentModal(comment) {
        currentComment = comment;

        // Populate modal with comment data
        document.getElementById('modalAvatar').textContent = comment.name.charAt(0).toUpperCase();
        document.getElementById('modalName').textContent = comment.name;
        document.getElementById('modalEmail').textContent = comment.email;
        document.getElementById('modalId').textContent = '#' + comment.id;
        document.getElementById('modalDate').textContent = new Date(comment.datetime).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        document.getElementById('modalPost').textContent = comment.post_title || 'N/A';
        document.getElementById('modalComment').textContent = comment.comment;

        // Set status badge
        const statusHtml = comment.status === 'ON' ?
            '<span class="px-4 py-2 inline-flex text-sm font-semibold rounded-full bg-green-100 text-green-800"><i class="fas fa-check mr-2"></i>Approved</span>' :
            '<span class="px-4 py-2 inline-flex text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800"><i class="fas fa-clock mr-2"></i>Pending</span>';
        document.getElementById('modalStatus').innerHTML = statusHtml;

        // Show/hide approve/disapprove buttons based on status
        document.getElementById('modalApproveBtn').style.display = comment.status === 'OFF' ? 'inline-block' : 'none';
        document.getElementById('modalDisapproveBtn').style.display = comment.status === 'ON' ? 'inline-block' : 'none';

        // Set up action buttons
        document.getElementById('modalApproveBtn').onclick = () => approveComment(comment.id);
        document.getElementById('modalDisapproveBtn').onclick = () => disapproveComment(comment.id);
        document.getElementById('modalDeleteBtn').onclick = () => deleteComment(comment.id);

        // Show modal
        document.getElementById('commentModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeCommentModal(event) {
        if (!event || event.target === event.currentTarget) {
            document.getElementById('commentModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    function approveComment(id) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/comments/${id}/approve`;
        document.body.appendChild(form);
        form.submit();
    }

    function disapproveComment(id) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/comments/${id}/disapprove`;
        document.body.appendChild(form);
        form.submit();
    }

    function deleteComment(id) {
        if (confirm('Are you sure you want to delete this comment? This action cannot be undone.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/comments/${id}/delete`;
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeCommentModal();
        }
    });
</script>