<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;
use App\Core\Session;

/**
 * ProfileController
 * 
 * Manage user profile in admin panel
 */
class ProfileController extends Controller
{
    /**
     * Show profile page
     */
    public function index(): void
    {
        $this->requireAuth();

        $userId = Session::userId();

        if (!$userId) {
            Session::flash('error', 'User not authenticated');
            $this->redirect('/login');
            return;
        }

        $profile = User::findById($userId);

        if (!$profile) {
            Session::flash('error', 'Profile not found');
            $this->redirect('/admin/dashboard');
            return;
        }

        $this->view('admin/profile/index', [
            'profile' => $profile,
            'title' => 'My Profile'
        ], 'layouts/admin');
    }

    /**
     * Update profile
     */
    public function update(): void
    {
        $this->requireAuth();

        $userId = Session::userId();

        if (!$userId) {
            Session::flash('error', 'User not authenticated');
            $this->redirect('/login');
            return;
        }

        // Get current user data
        $currentUser = User::findById($userId);

        if (!$currentUser) {
            Session::flash('error', 'User not found');
            $this->redirect('/admin/dashboard');
            return;
        }

        // Handle avatar upload
        $imageName = $currentUser['aimage'] ?? 'avatar.jpg';
        if (isset($_FILES['aimage']) && $_FILES['aimage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = PUBLIC_PATH . '/assets/images/';

            // Create images directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $imageName = time() . '_' . basename($_FILES['aimage']['name']);
            $uploadPath = $uploadDir . $imageName;

            if (!move_uploaded_file($_FILES['aimage']['tmp_name'], $uploadPath)) {
                Session::flash('error', 'Failed to upload avatar image');
                $this->redirect('/admin/profile');
                return;
            }

            // Delete old image if it's not the default
            if (!empty($currentUser['aimage']) && $currentUser['aimage'] !== 'avatar.jpg') {
                @unlink($uploadDir . $currentUser['aimage']);
            }
        }

        // Prepare update data
        $data = [
            'aname' => $_POST['aname'] ?? '',
            'aheadline' => $_POST['aheadline'] ?? '',
            'abio' => $_POST['abio'] ?? '',
            'aimage' => $imageName,
        ];

        // Update password if provided
        if (!empty($_POST['password'])) {
            $data['password'] = $_POST['password']; // In production, this should be hashed!
        }

        if (User::update($userId, $data)) {
            Session::flash('success', 'Profile updated successfully!');
        } else {
            Session::flash('error', 'Failed to update profile');
        }

        $this->redirect('/admin/profile');
    }
}
