<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Core\View;

/**
 * Base Controller
 * 
 * All controllers extend this class.
 * Provides common functionality like rendering views, redirecting, etc.
 * 
 * WHY?
 * - DRY: Don't repeat yourself - common code in one place
 * - Consistency: All controllers work the same way
 * - Easy to add global functionality (logging, auth checks, etc.)
 */
abstract class Controller
{
    protected Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * Render a view
     * 
     * @param string $view
     * @param array $data
     * @param string|null $layout
     */
    protected function view(string $view, array $data = [], ?string $layout = 'layouts/main'): void
    {
        View::render($view, $data, $layout);
    }

    /**
     * Render a partial view (without layout)
     * 
     * @param string $view
     * @param array $data
     */
    protected function partial(string $view, array $data = []): void
    {
        View::renderPartial($view, $data);
    }

    /**
     * Redirect to URL
     * 
     * @param string $url
     */
    protected function redirect(string $url): void
    {
        View::redirect($url);
    }

    /**
     * Redirect back
     */
    protected function redirectBack(): void
    {
        View::redirectBack();
    }

    /**
     * Return JSON response
     * 
     * @param array $data
     * @param int $statusCode
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        View::json($data, $statusCode);
    }

    /**
     * Check if user is authenticated, redirect to login if not
     */
    protected function requireAuth(): void
    {
        if (!Session::isAuthenticated()) {
            Session::flash('error', 'Please login to access this page');
            $this->redirect('/login');
        }
    }

    /**
     * Check if user is guest (not authenticated), redirect to dashboard if authenticated
     */
    protected function requireGuest(): void
    {
        if (Session::isAuthenticated()) {
            $this->redirect('/admin/dashboard');
        }
    }
}
