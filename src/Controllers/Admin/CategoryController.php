<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Category;
use App\Core\Session;

/**
 * CategoryController
 * 
 * Manage categories in admin panel
 */
class CategoryController extends Controller
{
    /**
     * List all categories
     */
    public function index(): void
    {
        $this->requireAuth();

        $categories = Category::all();

        $this->view('admin/categories/index', [
            'categories' => $categories,
            'title' => 'Manage Categories'
        ], 'layouts/admin');
    }

    /**
     * Show create category form
     */
    public function create(): void
    {
        $this->requireAuth();

        $this->view('admin/categories/create', [
            'title' => 'Create New Category'
        ], 'layouts/admin');
    }

    /**
     * Store new category
     */
    public function store(): void
    {
        $this->requireAuth();

        $user = Session::get('user');

        // Create category
        $data = [
            'title' => $_POST['title'] ?? '',
            'author' => $user['username'] ?? '',
            'datetime' => date('F-d-Y H:i:s'),
        ];

        if (Category::create($data)) {
            Session::flash('success', 'Category created successfully!');
            $this->redirect('/admin/categories');
        } else {
            Session::flash('error', 'Failed to create category');
            $this->redirect('/admin/categories/create');
        }
    }

    /**
     * Delete category
     */
    public function delete(int $id): void
    {
        $this->requireAuth();

        $category = Category::findById($id);

        if (!$category) {
            Session::flash('error', 'Category not found');
            $this->redirect('/admin/categories');
            return;
        }

        if (Category::delete($id)) {
            Session::flash('success', 'Category deleted successfully!');
        } else {
            Session::flash('error', 'Failed to delete category');
        }

        $this->redirect('/admin/categories');
    }
}
