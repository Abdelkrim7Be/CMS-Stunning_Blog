<?php

/**
 * Front Controller - Single Entry Point
 * 
 * This is the ONLY file that should be accessed by the web server.
 * All HTTP requests are routed through this file.
 * 
 * WHY? 
 * - Security: Only public/ folder is exposed to the web
 * - Clean URLs: No more Login.php, Dashboard.php in URLs
 * - Centralized control: One place to handle all requests
 * - Middleware support: Authentication, CSRF, etc. can be applied globally
 */

// Define absolute paths for the application
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/src');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('VIEW_PATH', ROOT_PATH . '/views');
define('STORAGE_PATH', ROOT_PATH . '/storage');
define('PUBLIC_PATH', __DIR__);

// Load Composer's autoloader
// This allows us to use classes without require_once statements
require_once ROOT_PATH . '/vendor/autoload.php';

// Load configuration files
$config = require_once CONFIG_PATH . '/app.php';
$dbConfig = require_once CONFIG_PATH . '/database.php';

// Start session management
use App\Core\Session;

Session::start();

// Set proper content type header
header('Content-Type: text/html; charset=UTF-8');

// Error reporting based on environment
if ($config['debug']) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// Set timezone
date_default_timezone_set($config['timezone']);

// Initialize core components
use App\Core\Router;
use App\Core\Database;

try {
    // Initialize database connection
    Database::init($dbConfig);

    // Initialize router
    $router = new Router();

    // Load routes
    require_once CONFIG_PATH . '/routes.php';

    // Dispatch the request
    // This will match the current URL to a route and execute the appropriate controller
    $router->dispatch();
} catch (\Exception $e) {
    // Error handling
    if ($config['debug']) {
        // In development, show detailed error
        echo '<h1>Application Error</h1>';
        echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    } else {
        // In production, show generic error and log the details
        error_log($e->getMessage());
        http_response_code(500);
        echo '<h1>Something went wrong</h1>';
        echo '<p>We are working to fix this issue.</p>';
    }
}
