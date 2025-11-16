<?php

namespace App\Controllers;

use App\Core\Session;
use App\Models\User;

/**
 * AuthController
 * 
 * Handles authentication: login, logout
 */
class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm(): void
    {
        // If already logged in, redirect to dashboard
        $this->requireGuest();

        $this->view('auth/login', [
            'title' => 'Login - Admin Panel'
        ], 'layouts/auth');
    }

    /**
     * Handle login submission
     */
    public function login(): void
    {
        $this->requireGuest();

        // Validate input
        $username = $this->request->post('username');
        $password = $this->request->post('password');

        if (empty($username) || empty($password)) {
            Session::flash('error', 'All fields are required');
            $this->redirect('/login');
        }

        // Verify credentials
        $user = User::verifyLogin($username, $password);

        if ($user) {
            // Login successful
            Session::login($user['id'], $user['username'], $user['aname']);
            Session::flash('success', "Welcome back, {$user['username']}!");

            // Redirect to intended page or dashboard
            $intendedUrl = Session::get('intended_url', '/admin/dashboard');
            Session::remove('intended_url');

            $this->redirect($intendedUrl);
        } else {
            // Login failed
            Session::flash('error', 'Invalid username or password');
            $this->redirect('/login');
        }
    }

    /**
     * Handle logout
     */
    public function logout(): void
    {
        Session::logout();
        Session::flash('success', 'You have been logged out successfully');
        $this->redirect('/login');
    }
}
