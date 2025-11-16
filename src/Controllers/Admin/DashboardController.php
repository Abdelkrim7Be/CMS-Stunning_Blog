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
            'pending_comments' => count($pendingComments), // Pass count for notification badge
            'pending_comments_list' => $pendingComments,    // Pass full list for dashboard display
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
        // Note: datetime is stored as VARCHAR in format "Month-DD-YYYY HH:MM:SS"
        // We'll extract year and month name, then convert to YYYY-MM format
        $postsQuery = "SELECT 
            CONCAT(
                SUBSTRING_INDEX(SUBSTRING_INDEX(datetime, ' ', 1), '-', -1),
                '-',
                LPAD(CASE SUBSTRING_INDEX(datetime, '-', 1)
                    WHEN 'January' THEN '01'
                    WHEN 'February' THEN '02'
                    WHEN 'March' THEN '03'
                    WHEN 'April' THEN '04'
                    WHEN 'May' THEN '05'
                    WHEN 'June' THEN '06'
                    WHEN 'July' THEN '07'
                    WHEN 'August' THEN '08'
                    WHEN 'September' THEN '09'
                    WHEN 'October' THEN '10'
                    WHEN 'November' THEN '11'
                    WHEN 'December' THEN '12'
                END, 2, '0')
            ) as month,
            COUNT(*) as count
            FROM posts
            WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(datetime, ' ', 1), '-', -1) >= YEAR(DATE_SUB(NOW(), INTERVAL 6 MONTH))
            GROUP BY month
            ORDER BY month ASC";
        $postsStmt = $db->query($postsQuery);
        $postsByMonth = $postsStmt->fetchAll(\PDO::FETCH_ASSOC);

        // Comments by month (last 6 months)
        $commentsQuery = "SELECT 
            CONCAT(
                SUBSTRING_INDEX(SUBSTRING_INDEX(datetime, ' ', 1), '-', -1),
                '-',
                LPAD(CASE SUBSTRING_INDEX(datetime, '-', 1)
                    WHEN 'January' THEN '01'
                    WHEN 'February' THEN '02'
                    WHEN 'March' THEN '03'
                    WHEN 'April' THEN '04'
                    WHEN 'May' THEN '05'
                    WHEN 'June' THEN '06'
                    WHEN 'July' THEN '07'
                    WHEN 'August' THEN '08'
                    WHEN 'September' THEN '09'
                    WHEN 'October' THEN '10'
                    WHEN 'November' THEN '11'
                    WHEN 'December' THEN '12'
                END, 2, '0')
            ) as month,
            COUNT(*) as count
            FROM comments
            WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(datetime, ' ', 1), '-', -1) >= YEAR(DATE_SUB(NOW(), INTERVAL 6 MONTH))
            GROUP BY month
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

    /**
     * Search functionality
     */
    public function search(): void
    {
        $this->requireAuth();

        $query = $_GET['q'] ?? '';
        $query = trim($query);

        $results = [
            'posts' => [],
            'categories' => [],
            'comments' => [],
        ];

        if (!empty($query)) {
            $db = Database::getConnection();

            // Search posts (title, post content, author)
            $postQuery = "SELECT id, title, category, author, datetime, 
                          SUBSTRING(post, 1, 200) as excerpt
                          FROM posts 
                          WHERE title LIKE :query1 
                             OR post LIKE :query2 
                             OR author LIKE :query3
                          ORDER BY datetime DESC
                          LIMIT 20";
            $stmt = $db->prepare($postQuery);
            $stmt->execute([
                'query1' => "%{$query}%",
                'query2' => "%{$query}%",
                'query3' => "%{$query}%"
            ]);
            $results['posts'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Search categories
            $categoryQuery = "SELECT * FROM category 
                             WHERE title LIKE :query
                             ORDER BY title ASC
                             LIMIT 10";
            $stmt = $db->prepare($categoryQuery);
            $stmt->execute(['query' => "%{$query}%"]);
            $results['categories'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Search comments
            $commentQuery = "SELECT c.*, p.title as post_title 
                            FROM comments c
                            LEFT JOIN posts p ON c.post_id = p.id
                            WHERE c.name LIKE :query1 
                               OR c.email LIKE :query2 
                               OR c.comment LIKE :query3
                            ORDER BY c.datetime DESC
                            LIMIT 20";
            $stmt = $db->prepare($commentQuery);
            $stmt->execute([
                'query1' => "%{$query}%",
                'query2' => "%{$query}%",
                'query3' => "%{$query}%"
            ]);
            $results['comments'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        // Get pending comments count for notifications
        $pendingCommentsCount = Comment::countPending();

        $this->view('admin/search', [
            'title' => 'Search Results - Admin Panel',
            'query' => $query,
            'results' => $results,
            'pending_comments' => $pendingCommentsCount,
        ], 'layouts/admin');
    }
}
