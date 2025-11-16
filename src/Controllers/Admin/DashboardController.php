<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use App\Core\Database;

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

        // Get analytics data for charts
        $analytics = $this->getAnalytics();

        $this->view('admin/dashboard', [
            'title' => 'Dashboard - Admin Panel',
            'stats' => $stats,
            'recent_posts' => $recentPosts,
            'pending_comments' => $pendingComments,
            'analytics' => $analytics,
        ], 'layouts/admin');
    }

    /**
     * Get analytics data for charts
     */
    private function getAnalytics(): array
    {
        $db = Database::getConnection();

        // Posts by month (last 6 months)
        $postsQuery = "SELECT 
            DATE_FORMAT(datetime, '%Y-%m') as month,
            COUNT(*) as count
            FROM posts
            WHERE datetime >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(datetime, '%Y-%m')
            ORDER BY month ASC";
        $postsStmt = $db->query($postsQuery);
        $postsByMonth = $postsStmt->fetchAll(\PDO::FETCH_ASSOC);

        // Comments by month (last 6 months)
        $commentsQuery = "SELECT 
            DATE_FORMAT(datetime, '%Y-%m') as month,
            COUNT(*) as count
            FROM comments
            WHERE datetime >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(datetime, '%Y-%m')
            ORDER BY month ASC";
        $commentsStmt = $db->query($commentsQuery);
        $commentsByMonth = $commentsStmt->fetchAll(\PDO::FETCH_ASSOC);

        // Posts by category
        $categoryQuery = "SELECT 
            c.title as name,
            COUNT(p.id) as count
            FROM category c
            LEFT JOIN posts p ON c.title = p.category
            GROUP BY c.id, c.title
            ORDER BY count DESC";
        $categoryStmt = $db->query($categoryQuery);
        $postsByCategory = $categoryStmt->fetchAll(\PDO::FETCH_ASSOC);

        // Comments status distribution
        $statusQuery = "SELECT 
            status,
            COUNT(*) as count
            FROM comments
            GROUP BY status";
        $statusStmt = $db->query($statusQuery);
        $commentsByStatus = $statusStmt->fetchAll(\PDO::FETCH_ASSOC);

        return [
            'posts_by_month' => $postsByMonth,
            'comments_by_month' => $commentsByMonth,
            'posts_by_category' => $postsByCategory,
            'comments_by_status' => $commentsByStatus,
        ];
    }
}
