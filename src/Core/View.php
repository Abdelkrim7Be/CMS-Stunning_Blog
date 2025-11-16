<?php

namespace App\Core;

/**
 * View Class
 * 
 * Handles rendering of view templates.
 * Separates HTML from PHP logic.
 * 
 * USAGE:
 * View::render('auth/login', ['title' => 'Login Page']);
 * 
 * This will load: views/auth/login.php
 * And make $title variable available in that view
 */
class View
{
    /**
     * Render a view template
     * 
     * @param string $view View file name (without .php)
     * @param array $data Data to pass to the view
     * @param string|null $layout Layout file to use
     */
    public static function render(string $view, array $data = [], ?string $layout = 'layouts/main'): void
    {
        // Extract data array to variables
        // ['title' => 'Login'] becomes $title = 'Login'
        extract($data);

        // Start output buffering
        ob_start();

        // Load the view file
        $viewFile = VIEW_PATH . '/' . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found: {$viewFile}");
        }

        require $viewFile;

        // Get the view content
        $content = ob_get_clean();

        // If layout is specified, render it with the view content
        if ($layout) {
            $layoutFile = VIEW_PATH . '/' . $layout . '.php';

            if (file_exists($layoutFile)) {
                require $layoutFile;
            } else {
                // No layout found, just output the content
                echo $content;
            }
        } else {
            // No layout, just output the content
            echo $content;
        }
    }

    /**
     * Render a view without a layout
     * 
     * @param string $view View file name
     * @param array $data Data to pass to the view
     */
    public static function renderPartial(string $view, array $data = []): void
    {
        self::render($view, $data, null);
    }

    /**
     * Redirect to a URL
     * 
     * @param string $url
     */
    public static function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Redirect back to previous page
     */
    public static function redirectBack(): void
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        self::redirect($referer);
    }

    /**
     * Return JSON response
     * 
     * @param array $data
     * @param int $statusCode
     */
    public static function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
