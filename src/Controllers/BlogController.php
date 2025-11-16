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
        // Initialize variables
        $posts = [];
        $totalPosts = 0;
        $currentPage = 1;
        $postsPerPage = 5;
        $searchQuery = null;
        $categoryFilter = null;

        // Handle SEARCH functionality
        if (isset($_GET['SearchButton']) && !empty($_GET['Search'])) {
            $searchQuery = htmlspecialchars($_GET['Search']);
            $posts = Post::search($searchQuery);
            $totalPosts = count($posts);
        }
        // Handle CATEGORY filtering
        elseif (isset($_GET['category']) && !empty($_GET['category'])) {
            $categoryFilter = htmlspecialchars($_GET['category']);
            $posts = Post::getByCategoryName($categoryFilter);
            $totalPosts = count($posts);
        }
        // Handle PAGINATION
        elseif (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $currentPage = max(1, (int)$_GET['page']);
            $posts = Post::getAllPosts($currentPage, $postsPerPage);
            $totalPosts = Post::getTotalCount();
        }
        // Default: Show first 3 posts
        else {
            $posts = Post::getAllPosts(1, 3);
            $totalPosts = Post::getTotalCount();
        }

        // Get all categories for sidebar
        $categories = Category::all();

        // Calculate pagination
        $totalPages = ceil($totalPosts / $postsPerPage);

        // Render the view with data
        $this->view('blog/index', [
            'title' => 'Blog - ABDELKRIMBELLAGNECH.COM',
            'posts' => $posts,
            'categories' => $categories,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'postsPerPage' => $postsPerPage,
            'searchQuery' => $searchQuery,
            'categoryFilter' => $categoryFilter,
        ], 'layouts/main');
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
}
