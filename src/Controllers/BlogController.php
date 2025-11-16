<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Category;

/**
 * BlogController
 * 
 * Handles public blog pages
 */
class BlogController extends Controller
{
    /**
     * Show blog homepage
     */
    public function index(): void
    {
        $posts = Post::all(10, 0);
        $categories = Category::all();

        $this->view('blog/index', [
            'title' => 'Home - Stunning Blog',
            'posts' => $posts,
            'categories' => $categories,
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
