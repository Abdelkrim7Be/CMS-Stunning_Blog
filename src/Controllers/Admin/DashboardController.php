<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;

/**
 * DashboardController
 * 
 * Admin dashboard with statistics
 */
class DashboardController extends Controller
{
    /**
     * Show dashboard
     */
    public function index(): void
    {
        // Require authentication
        $this->requireAuth();

        // Get statistics
        $stats = [
            'total_posts' => Post::count(),
            'total_categories' => Category::count(),
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::countPending(),
            'total_admins' => User::count(),
        ];

        // Get recent posts
        $recentPosts = Post::all(5, 0);

        // Get pending comments
        $pendingComments = Comment::pending();

        $this->view('admin/dashboard', [
            'title' => 'Dashboard - Admin Panel',
            'stats' => $stats,
            'recent_posts' => $recentPosts,
            'pending_comments' => $pendingComments,
        ], 'layouts/admin');
    }
}
