<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;
use App\Models\Comment;
use App\Core\Session;
use App\Core\Role;

/**
 * AdminController
 * 
 * Manage admin users in admin panel
 */
class AdminController extends Controller
{
    /**
     * List all admins
     */
    public function index(): void
    {
        $this->requirePermission('manage_admins', 'Only administrators can manage users');

        // Pagination
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        // Get total count
        $totalAdmins = User::count();
        $totalPages = ceil($totalAdmins / $perPage);

        // Get paginated admins
        $admins = User::paginate($perPage, $offset);

        $this->view('admin/admins/index', [
            'admins' => $admins,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'title' => 'Manage Admins',
            'pending_comments' => Comment::countPending(),
        ], 'layouts/admin');
    }

    /**
     * Show create admin form
     */
    public function create(): void
    {
        $this->requirePermission('manage_admins', 'Only administrators can create new users');

        // Get roles that current user can assign
        $userRole = Session::role();
        $availableRoles = Role::getManageableRoles($userRole);

        $this->view('admin/admins/create', [
            'title' => 'Create New Admin',
            'available_roles' => $availableRoles,
            'pending_comments' => Comment::countPending(),
        ], 'layouts/admin');
    }

    /**
     * Store new admin
     */
    public function store(): void
    {
        $this->requirePermission('manage_admins', 'Only administrators can create new users');

        $username = $this->request->post('username');
        $password = $this->request->post('password');
        $aname = $this->request->post('aname');
        $role = $this->request->post('role', 'author');

        // Validate required fields
        if (empty($username) || empty($password) || empty($aname)) {
            Session::flash('error', 'All fields are required');
            $this->redirect('/admin/admins/create');
            return;
        }

        // Check if username already exists
        if (User::findByUsername($username)) {
            Session::flash('error', 'Username already exists');
            $this->redirect('/admin/admins/create');
            return;
        }

        // Validate role assignment - can't assign role equal or higher than own role
        $userRole = Session::role();
        if (!Role::isHigherThan($userRole, $role)) {
            Session::flash('error', 'You cannot assign a role equal or higher than your own');
            $this->redirect('/admin/admins/create');
            return;
        }

        // Create admin
        $data = [
            'username' => $username,
            'password' => $password,
            'aname' => $aname,
            'role' => $role,
            'added_by' => Session::username(),
            'aheadline' => $this->request->post('aheadline', ''),
            'abio' => $this->request->post('abio', ''),
        ];

        if (User::create($data)) {
            Session::flash('success', 'Admin created successfully!');
            $this->redirect('/admin/admins');
        } else {
            Session::flash('error', 'Failed to create admin');
            $this->redirect('/admin/admins/create');
        }
    }

    /**
     * Show edit admin form
     */
    public function edit(int $id): void
    {
        $this->requirePermission('manage_admins', 'Only administrators can edit users');

        $admin = User::findById($id);

        if (!$admin) {
            Session::flash('error', 'Admin not found');
            $this->redirect('/admin/admins');
            return;
        }

        // Can't edit someone with equal or higher role
        $userRole = Session::role();
        if (!Role::isHigherThan($userRole, $admin['role'])) {
            Session::flash('error', 'You cannot edit an admin with equal or higher role');
            $this->redirect('/admin/admins');
            return;
        }

        // Get roles that current user can assign
        $availableRoles = Role::getManageableRoles($userRole);

        $this->view('admin/admins/edit', [
            'admin' => $admin,
            'available_roles' => $availableRoles,
            'title' => 'Edit Admin',
            'pending_comments' => Comment::countPending(),
        ], 'layouts/admin');
    }

    /**
     * Update admin
     */
    public function update(int $id): void
    {
        $this->requirePermission('manage_admins', 'Only administrators can update users');

        $admin = User::findById($id);

        if (!$admin) {
            Session::flash('error', 'Admin not found');
            $this->redirect('/admin/admins');
            return;
        }

        // Can't edit someone with equal or higher role
        $userRole = Session::role();
        if (!Role::isHigherThan($userRole, $admin['role'])) {
            Session::flash('error', 'You cannot edit an admin with equal or higher role');
            $this->redirect('/admin/admins');
            return;
        }

        $role = $this->request->post('role', $admin['role']);

        // Validate new role assignment
        if (!Role::isHigherThan($userRole, $role)) {
            Session::flash('error', 'You cannot assign a role equal or higher than your own');
            $this->redirect('/admin/admins/edit/' . $id);
            return;
        }

        $data = [
            'username' => $this->request->post('username', $admin['username']),
            'aname' => $this->request->post('aname', $admin['aname']),
            'role' => $role,
            'aheadline' => $this->request->post('aheadline', $admin['aheadline']),
            'abio' => $this->request->post('abio', $admin['abio']),
        ];

        // Update password if provided
        $password = $this->request->post('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }

        if (User::update($id, $data)) {
            Session::flash('success', 'Admin updated successfully!');
            $this->redirect('/admin/admins');
        } else {
            Session::flash('error', 'Failed to update admin');
            $this->redirect('/admin/admins/edit/' . $id);
        }
    }

    /**
     * Delete admin
     */
    public function delete(int $id): void
    {
        $this->requirePermission('manage_admins', 'Only administrators can delete users');

        $currentUserId = Session::userId();

        // Prevent deleting yourself
        if ($currentUserId && $currentUserId == $id) {
            Session::flash('error', 'You cannot delete your own account!');
            $this->redirect('/admin/admins');
            return;
        }

        $admin = User::findById($id);

        if (!$admin) {
            Session::flash('error', 'Admin not found');
            $this->redirect('/admin/admins');
            return;
        }

        // Can't delete someone with equal or higher role
        $userRole = Session::role();
        if (!Role::isHigherThan($userRole, $admin['role'])) {
            Session::flash('error', 'You cannot delete an admin with equal or higher role');
            $this->redirect('/admin/admins');
            return;
        }

        if (User::delete($id)) {
            Session::flash('success', 'Admin deleted successfully!');
        } else {
            Session::flash('error', 'Failed to delete admin');
        }

        $this->redirect('/admin/admins');
    }
}
