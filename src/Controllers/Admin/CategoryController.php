<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
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

        // Pagination
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        $offset = ($currentPage - 1) * $perPage;

        // Get total count and calculate pages
        $totalCategories = Category::count();
        $totalPages = ceil($totalCategories / $perPage);

        // Get paginated categories
        $categories = Category::paginate($perPage, $offset);

        $this->view('admin/categories/index', [
            'categories' => $categories,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalCategories' => $totalCategories,
            'title' => 'Manage Categories',
            'pending_comments' => Comment::countPending(),
        ], 'layouts/admin');
    }

    /**
     * Show create category form
     */
    public function create(): void
    {
        $this->requirePermission('manage_categories', 'Only admins and above can create categories');

        $this->view('admin/categories/create', [
            'title' => 'Create New Category',
            'pending_comments' => Comment::countPending(),
        ], 'layouts/admin');
    }

    /**
     * Store new category
     */
    public function store(): void
    {
        $this->requirePermission('manage_categories', 'Only admins and above can create categories');

        // Create category
        $data = [
            'title' => $_POST['title'] ?? '',
            'author' => Session::username() ?? 'Unknown',
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
        $this->requirePermission('manage_categories', 'Only admins and above can delete categories');

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
