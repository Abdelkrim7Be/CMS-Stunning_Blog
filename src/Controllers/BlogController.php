<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Category;

/**
 * BlogController
 * 
 * Handles public blog pages
 * Refactored from legacy Blog.php to follow MVC architecture
 */
class BlogController extends Controller
{
    /**
     * Show blog homepage
     * 
     * Handles:
     * - Default blog listing with pagination
     * - Search functionality
     * - Category filtering
     */
    public function index(): void
    {
        // Handle newsletter subscription
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newsletter_email'])) {
            $email = filter_var($_POST['newsletter_email'], FILTER_VALIDATE_EMAIL);
            if ($email) {
                // Here you could save to database, but for now just redirect with success
                header('Location: /?subscribed=1');
                exit;
            }
        }

        // Initialize variables
        $posts = [];
        $totalPosts = 0;
        $currentPage = 1;
        $postsPerPage = 5;
        $searchQuery = null;
        $categoryFilter = null;

        // Handle SEARCH functionality
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchQuery = htmlspecialchars($_GET['search']);
            $posts = Post::search($searchQuery);
            $totalPosts = count($posts);
            // Apply pagination to search results
            $totalPages = ceil($totalPosts / $postsPerPage);
            $offset = ($currentPage - 1) * $postsPerPage;
            $posts = array_slice($posts, $offset, $postsPerPage);
        }
        // Handle CATEGORY filtering
        elseif (isset($_GET['category']) && !empty($_GET['category'])) {
            $categoryFilter = htmlspecialchars($_GET['category']);
            $posts = Post::getByCategoryName($categoryFilter);
            $totalPosts = count($posts);
            // Apply pagination to category results
            $totalPages = ceil($totalPosts / $postsPerPage);
            $offset = ($currentPage - 1) * $postsPerPage;
            $posts = array_slice($posts, $offset, $postsPerPage);
        }
        // Handle PAGINATION
        elseif (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $currentPage = max(1, (int)$_GET['page']);
            $posts = Post::getAllPosts($currentPage, $postsPerPage);
            $totalPosts = Post::getTotalCount();
        }
        // Default: Show first 5 posts
        else {
            $posts = Post::getAllPosts(1, $postsPerPage);
            $totalPosts = Post::getTotalCount();
        }

        // Get all categories for sidebar
        $categories = Category::all();

        // Calculate pagination
        $totalPages = ceil($totalPosts / $postsPerPage);

        // Render the view with data
        $this->view('blog/home', [
            'title' => 'Stunning Blog - Modern Content Platform',
            'posts' => $posts,
            'categories' => $categories,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'postsPerPage' => $postsPerPage,
            'searchQuery' => $searchQuery,
            'categoryFilter' => $categoryFilter,
        ], 'layouts/blog');
    }

    /**
     * Show single post
     * 
     * @param int $id
     */
    public function show(int $id): void
    {
        $post = Post::findById($id);

        if (!$post) {
            http_response_code(404);
            $this->view('errors/404', [], null);
            return;
        }

        // Handle comment submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
            $name = htmlspecialchars(trim($_POST['name'] ?? ''));
            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $commentText = htmlspecialchars(trim($_POST['comment'] ?? ''));

            if ($name && $email && $commentText) {
                // Insert comment into database (status OFF = pending approval)
                $sql = "INSERT INTO comments (post_id, name, email, comment, datetime, status) 
                        VALUES (:post_id, :name, :email, :comment, NOW(), 'OFF')";

                try {
                    \App\Core\Database::execute($sql, [
                        'post_id' => $id,
                        'name' => $name,
                        'email' => $email,
                        'comment' => $commentText
                    ]);

                    // Redirect with success message
                    header('Location: /post/' . $id . '?comment_success=1');
                    exit;
                } catch (\Exception $e) {
                    // Log error but continue to show page
                    error_log('Comment submission failed: ' . $e->getMessage());
                }
            }
        }

        $this->view('blog/post', [
            'title' => $post['title'] . ' - Stunning Blog',
            'post' => $post,
        ], 'layouts/blog');
    }

    /**
     * Show posts by category
     * 
     * @param int $id
     */
    public function category(int $id): void
    {
        $category = Category::findById($id);

        if (!$category) {
            http_response_code(404);
            $this->view('errors/404', [], null);
            return;
        }

        $posts = Post::byCategory($id);

        $this->view('blog/category', [
            'title' => $category['title'] . ' - Stunning Blog',
            'category' => $category,
            'posts' => $posts,
        ], 'layouts/blog');
    }

    /**
     * Show about page
     */
    public function about(): void
    {
        $this->view('blog/about', [
            'title' => 'About Us - Stunning Blog',
        ], 'layouts/blog');
    }

    /**
     * Show author profile page
     */
    public function profile(): void
    {
        $username = $_GET['username'] ?? null;

        if (!$username) {
            http_response_code(404);
            $this->view('errors/404', [], null);
            return;
        }

        // Get author info from admins table
        $sql = "SELECT username, aname, aheadline, abio, aimage FROM admins WHERE username = :username LIMIT 1";
        $author = \App\Core\Database::query($sql, ['username' => $username]);

        if (empty($author)) {
            http_response_code(404);
            $this->view('errors/404', [], null);
            return;
        }

        $author = $author[0];

        // Get author's posts
        $posts = Post::getByAuthor($username);

        $this->view('blog/profile', [
            'title' => $author['aname'] . ' - Author Profile',
            'author' => $author,
            'posts' => $posts,
        ], 'layouts/blog');
    }
}
