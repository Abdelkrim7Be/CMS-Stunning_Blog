<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Comment;
use App\Core\Session;

/**
 * CommentController
 * 
 * Manage comments in admin panel
 */
class CommentController extends Controller
{
    /**
     * List all comments
     */
    public function index(): void
    {
        $this->requireAuth();

        // Pagination
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        // Get total count
        $totalComments = Comment::count();
        $totalPages = ceil($totalComments / $perPage);

        // Get paginated comments
        $comments = Comment::paginate($perPage, $offset);

        $this->view('admin/comments/index', [
            'comments' => $comments,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalComments' => $totalComments,
            'title' => 'Manage Comments',
            'pending_comments' => Comment::countPending(),
        ], 'layouts/admin');
    }

    /**
     * Approve comment
     */
    public function approve(int $id): void
    {
        $this->requireAuth();

        $user = Session::get('user');

        if (Comment::approve($id, $user['username'] ?? 'Admin')) {
            Session::flash('success', 'Comment approved successfully!');
        } else {
            Session::flash('error', 'Failed to approve comment');
        }

        // Redirect back to where the request came from
        $redirect = $_POST['redirect'] ?? '/admin/comments';
        $this->redirect($redirect);
    }

    /**
     * Disapprove comment
     */
    public function disapprove(int $id): void
    {
        $this->requireAuth();

        if (Comment::disapprove($id)) {
            Session::flash('success', 'Comment disapproved successfully!');
        } else {
            Session::flash('error', 'Failed to disapprove comment');
        }

        // Redirect back to where the request came from
        $redirect = $_POST['redirect'] ?? '/admin/comments';
        $this->redirect($redirect);
    }

    /**
     * Delete comment
     */
    public function delete(int $id): void
    {
        $this->requireAuth();

        if (Comment::delete($id)) {
            Session::flash('success', 'Comment deleted successfully!');
        } else {
            Session::flash('error', 'Failed to delete comment');
        }

        $this->redirect('/admin/comments');
    }
}
