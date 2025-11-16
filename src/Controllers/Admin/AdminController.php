<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;
use App\Core\Session;

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
        $this->requireAuth();

        $admins = User::all();

        $this->view('admin/admins/index', [
            'admins' => $admins,
            'title' => 'Manage Admins'
        ], 'layouts/admin');
    }

    /**
     * Delete admin
     */
    public function delete(int $id): void
    {
        $this->requireAuth();

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

        if (User::delete($id)) {
            Session::flash('success', 'Admin deleted successfully!');
        } else {
            Session::flash('error', 'Failed to delete admin');
        }

        $this->redirect('/admin/admins');
    }
}
