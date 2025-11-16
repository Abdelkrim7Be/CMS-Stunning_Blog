<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
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

        $posts = Post::all(100); // Get all posts

        $this->view('admin/posts/index', [
            'posts' => $posts,
            'title' => 'Manage Posts'
        ], 'layouts/admin');
    }

    /**
     * Show create post form
     */
    public function create(): void
    {
        $this->requireAuth();

        $categories = Category::all();

        $this->view('admin/posts/create', [
            'categories' => $categories,
            'title' => 'Create New Post'
        ], 'layouts/admin');
    }

    /**
     * Store new post
     */
    public function store(): void
    {
        $this->requireAuth();

        $user = Session::get('user');

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
            'author' => $user['username'] ?? '',
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

        $categories = Category::all();

        $this->view('admin/posts/edit', [
            'post' => $post,
            'categories' => $categories,
            'title' => 'Edit Post'
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
