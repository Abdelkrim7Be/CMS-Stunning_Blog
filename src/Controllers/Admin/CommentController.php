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

        $comments = Comment::all();

        $this->view('admin/comments/index', [
            'comments' => $comments,
            'title' => 'Manage Comments'
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

        $this->redirect('/admin/comments');
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

        $this->redirect('/admin/comments');
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
