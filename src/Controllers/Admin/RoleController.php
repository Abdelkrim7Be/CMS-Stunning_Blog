<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;
use App\Models\Comment;
use App\Core\Session;
use App\Core\Role;
use App\Core\Database;

/**
 * RoleController
 * 
 * Manage roles and permissions in admin panel
 */
class RoleController extends Controller
{
    /**
     * Display role management dashboard
     */
    public function index(): void
    {
        $this->requirePermission('manage_admins', 'Only super admins can manage roles');

        $roles = Role::getAllRoles();
        $permissions = Role::getAllPermissions();

        $this->view('admin/roles/index', [
            'roles' => $roles,
            'permissions' => $permissions,
            'title' => 'Role Management',
            'pending_comments' => Comment::countPending(),
        ], 'layouts/admin');
    }

    /**
     * Show form to assign role to user
     */
    public function assign(): void
    {
        $this->requirePermission('manage_admins', 'Only administrators can assign roles');

        $users = User::all();
        $userRole = Session::role();
        $availableRoles = Role::getManageableRoles($userRole);

        $this->view('admin/roles/assign', [
            'users' => $users,
            'available_roles' => $availableRoles,
            'title' => 'Assign Role',
            'pending_comments' => Comment::countPending(),
        ], 'layouts/admin');
    }

    /**
     * Update user role
     */
    public function updateUserRole(): void
    {
        $this->requirePermission('manage_admins', 'Only administrators can assign roles');

        $userId = $this->request->post('user_id');
        $newRole = $this->request->post('role');

        if (!$userId || !$newRole) {
            Session::flash('error', 'User ID and role are required');
            $this->redirect('/admin/roles/assign');
            return;
        }

        $user = User::findById($userId);

        if (!$user) {
            Session::flash('error', 'User not found');
            $this->redirect('/admin/roles/assign');
            return;
        }

        // Validate role assignment - can't assign role equal or higher than own role
        $currentUserRole = Session::role();

        // Can't modify someone with equal or higher role
        if (!Role::isHigherThan($currentUserRole, $user['role'])) {
            Session::flash('error', 'You cannot modify a user with equal or higher role');
            $this->redirect('/admin/roles/assign');
            return;
        }

        // Can't assign role equal or higher than own role
        if (!Role::isHigherThan($currentUserRole, $newRole)) {
            Session::flash('error', 'You cannot assign a role equal or higher than your own');
            $this->redirect('/admin/roles/assign');
            return;
        }

        // Update role
        if (User::updateRole($userId, $newRole)) {
            Session::flash('success', "Role updated successfully! {$user['username']} is now a " . ucwords(str_replace('_', ' ', $newRole)));
            $this->redirect('/admin/roles/assign');
        } else {
            Session::flash('error', 'Failed to update role');
            $this->redirect('/admin/roles/assign');
        }
    }

    /**
     * Show permissions for a specific role
     */
    public function showPermissions(string $role): void
    {
        $this->requirePermission('manage_admins', 'Only administrators can view role details');

        if (!Role::isValidRole($role)) {
            Session::flash('error', 'Invalid role');
            $this->redirect('/admin/roles');
            return;
        }

        $permissions = Role::getPermissionsForRole($role);
        $allPermissions = Role::getAllPermissions();
        $roleInfo = Role::getRoleInfo($role);

        $this->view('admin/roles/permissions', [
            'role' => $role,
            'role_info' => $roleInfo,
            'permissions' => $permissions,
            'all_permissions' => $allPermissions,
            'title' => ucwords(str_replace('_', ' ', $role)) . ' Permissions',
            'pending_comments' => Comment::countPending(),
        ], 'layouts/admin');
    }

    /**
     * Show users by role
     */
    public function usersByRole(string $role): void
    {
        $this->requirePermission('manage_admins', 'Only administrators can view users by role');

        if (!Role::isValidRole($role)) {
            Session::flash('error', 'Invalid role');
            $this->redirect('/admin/roles');
            return;
        }

        $users = User::findByRole($role);
        $roleInfo = Role::getRoleInfo($role);

        $this->view('admin/roles/users', [
            'role' => $role,
            'role_info' => $roleInfo,
            'users' => $users,
            'title' => ucwords(str_replace('_', ' ', $role)) . ' Users',
            'pending_comments' => Comment::countPending(),
        ], 'layouts/admin');
    }

    /**
     * Bulk role assignment
     */
    public function bulkAssign(): void
    {
        $this->requirePermission('manage_admins', 'Only administrators can perform bulk operations');

        $userIds = $this->request->post('user_ids', []);
        $newRole = $this->request->post('role');

        if (empty($userIds) || !$newRole) {
            Session::flash('error', 'Please select users and a role');
            $this->redirect('/admin/roles/assign');
            return;
        }

        $currentUserRole = Session::role();

        // Can't assign role equal or higher than own role
        if (!Role::isHigherThan($currentUserRole, $newRole)) {
            Session::flash('error', 'You cannot assign a role equal or higher than your own');
            $this->redirect('/admin/roles/assign');
            return;
        }

        $updated = 0;
        $failed = 0;

        foreach ($userIds as $userId) {
            $user = User::findById($userId);

            if (!$user) {
                $failed++;
                continue;
            }

            // Can't modify someone with equal or higher role
            if (!Role::isHigherThan($currentUserRole, $user['role'])) {
                $failed++;
                continue;
            }

            if (User::updateRole($userId, $newRole)) {
                $updated++;
            } else {
                $failed++;
            }
        }

        if ($updated > 0) {
            Session::flash('success', "Successfully updated {$updated} user(s) to " . ucwords(str_replace('_', ' ', $newRole)));
        }

        if ($failed > 0) {
            Session::flash('error', "Failed to update {$failed} user(s)");
        }

        $this->redirect('/admin/roles/assign');
    }
}
