<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Core\Session;

/**
 * PostController
 * 
 * Manage blog posts in admin panel
 */
class PostController extends Controller
{
    /**
     * List all posts
     */
    public function index(): void
    {
        $this->requireAuth();

        // Pagination
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        // Get total count
        $totalPosts = Post::count();
        $totalPages = ceil($totalPosts / $perPage);

        // Get paginated posts
        $posts = Post::all($perPage, $offset);

        $this->view('admin/posts/index', [
            'posts' => $posts,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPosts' => $totalPosts,
            'title' => 'Manage Posts',
            'pending_comments' => Comment::countPending(),
        ], 'layouts/admin');
    }

    /**
     * Show create post form
     */
    public function create(): void
    {
        // Authors and above can create posts
        $this->requireAuth();

        $categories = Category::all();

        $this->view('admin/posts/create', [
            'categories' => $categories,
            'title' => 'Create New Post',
            'pending_comments' => Comment::countPending(),
        ], 'layouts/admin');
    }

    /**
     * Store new post
     */
    public function store(): void
    {
        // Authors and above can create posts
        $this->requireAuth();

        // Handle file upload
        $imageName = 'default.jpg';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = PUBLIC_PATH . '/uploads/';
            $imageName = time() . '_' . basename($_FILES['image']['name']);
            $uploadPath = $uploadDir . $imageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                Session::flash('error', 'Failed to upload image');
                $this->redirect('/admin/posts/create');
                return;
            }
        }

        // Create post
        $data = [
            'datetime' => date('F-d-Y H:i:s'),
            'title' => $_POST['title'] ?? '',
            'category' => $_POST['category'] ?? '',
            'author' => Session::username() ?? 'Unknown',
            'image' => $imageName,
            'post' => $_POST['post'] ?? '',
        ];

        if (Post::create($data)) {
            Session::flash('success', 'Post created successfully!');
            $this->redirect('/admin/posts');
        } else {
            Session::flash('error', 'Failed to create post');
            $this->redirect('/admin/posts/create');
        }
    }

    /**
     * Show edit post form
     */
    public function edit(int $id): void
    {
        $this->requireAuth();

        $post = Post::findById($id);

        if (!$post) {
            Session::flash('error', 'Post not found');
            $this->redirect('/admin/posts');
            return;
        }

        // Check if user can edit this post
        // Authors can only edit their own posts, Editors and above can edit any post
        if (!Session::can('manage_all_posts') && $post['author'] !== Session::username()) {
            Session::flash('error', 'You can only edit your own posts');
            $this->redirect('/admin/posts');
            return;
        }

        $categories = Category::all();

        $this->view('admin/posts/edit', [
            'post' => $post,
            'categories' => $categories,
            'title' => 'Edit Post',
            'pending_comments' => Comment::countPending(),
        ], 'layouts/admin');
    }

    /**
     * Update post
     */
    public function update(int $id): void
    {
        $this->requireAuth();

        $post = Post::findById($id);

        if (!$post) {
            Session::flash('error', 'Post not found');
            $this->redirect('/admin/posts');
            return;
        }

        // Check if user can edit this post
        if (!Session::can('manage_all_posts') && $post['author'] !== Session::username()) {
            Session::flash('error', 'You can only edit your own posts');
            $this->redirect('/admin/posts');
            return;
        }

        // Handle file upload
        $imageName = $post['image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = PUBLIC_PATH . '/uploads/';
            $imageName = time() . '_' . basename($_FILES['image']['name']);
            $uploadPath = $uploadDir . $imageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                Session::flash('error', 'Failed to upload image');
                $this->redirect('/admin/posts/' . $id . '/edit');
                return;
            }

            // Delete old image if it's not the default
            if ($post['image'] !== 'default.jpg') {
                @unlink($uploadDir . $post['image']);
            }
        }

        // Update post
        $data = [
            'title' => $_POST['title'] ?? '',
            'category' => $_POST['category'] ?? '',
            'image' => $imageName,
            'post' => $_POST['post'] ?? '',
        ];

        if (Post::update($id, $data)) {
            Session::flash('success', 'Post updated successfully!');
            $this->redirect('/admin/posts');
        } else {
            Session::flash('error', 'Failed to update post');
            $this->redirect('/admin/posts/' . $id . '/edit');
        }
    }

    /**
     * Delete post
     */
    public function delete(int $id): void
    {
        $this->requireAuth();

        $post = Post::findById($id);

        if (!$post) {
            Session::flash('error', 'Post not found');
            $this->redirect('/admin/posts');
            return;
        }

        // Check if user can delete this post
        // Authors can only delete their own posts, Editors and above can delete any post
        if (!Session::can('delete_any_post') && $post['author'] !== Session::username()) {
            Session::flash('error', 'You can only delete your own posts');
            $this->redirect('/admin/posts');
            return;
        }

        // Delete image file if it's not the default
        if ($post['image'] !== 'default.jpg') {
            $uploadDir = PUBLIC_PATH . '/uploads/';
            @unlink($uploadDir . $post['image']);
        }

        if (Post::delete($id)) {
            Session::flash('success', 'Post deleted successfully!');
        } else {
            Session::flash('error', 'Failed to delete post');
        }

        $this->redirect('/admin/posts');
    }
}
