<?php

namespace App\Core;

/**
 * Router Class
 * 
 * Handles URL routing and maps URLs to Controllers.
 * Supports dynamic parameters like /post/{id}
 * 
 * HOW IT WORKS:
 * 1. Register routes: $router->get('/login', 'AuthController@showLoginForm')
 * 2. When request comes in, dispatch() matches URL to route
 * 3. Extracts controller name, method name, and parameters
 * 4. Instantiates controller and calls the method
 */
class Router
{
    private array $routes = [];
    private string $basePath = '';

    /**
     * Set base path for the router (useful for subdirectories)
     * 
     * @param string $basePath
     */
    public function setBasePath(string $basePath): void
    {
        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * Register a GET route
     * 
     * @param string $path URL path (e.g., '/login' or '/post/{id}')
     * @param string $handler Controller@method (e.g., 'AuthController@login')
     */
    public function get(string $path, string $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    /**
     * Register a POST route
     * 
     * @param string $path URL path
     * @param string $handler Controller@method
     */
    public function post(string $path, string $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    /**
     * Add a route to the routing table
     * 
     * @param string $method HTTP method
     * @param string $path URL path
     * @param string $handler Controller@method
     */
    private function addRoute(string $method, string $path, string $handler): void
    {
        // Convert route path to regex pattern
        // /post/{id} becomes /post/([^/]+)
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'pattern' => $pattern,
            'handler' => $handler,
        ];
    }

    /**
     * Dispatch the request to the appropriate controller
     * 
     * @throws \Exception
     */
    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];

        // Remove query string and base path
        $requestUri = strtok($requestUri, '?');

        if ($this->basePath) {
            $requestUri = substr($requestUri, strlen($this->basePath));
        }

        $requestUri = '/' . trim($requestUri, '/');
        if ($requestUri !== '/') {
            $requestUri = rtrim($requestUri, '/');
        }

        // Find matching route
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && preg_match($route['pattern'], $requestUri, $matches)) {
                // Remove the full match, keep only captured groups (parameters)
                array_shift($matches);

                $this->callController($route['handler'], $matches);
                return;
            }
        }

        // No route found - 404
        $this->handleNotFound();
    }

    /**
     * Call the controller method
     * 
     * @param string $handler Controller@method
     * @param array $params URL parameters
     * @throws \Exception
     */
    private function callController(string $handler, array $params = []): void
    {
        [$controllerName, $method] = explode('@', $handler);

        // Build the full controller class name
        // The handler can be either "BlogController" or "Admin\DashboardController"
        $controllerClass = "App\\Controllers\\{$controllerName}";

        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller {$controllerName} not found");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            throw new \Exception("Method {$method} not found in controller {$controllerClass}");
        }

        // Call the controller method with parameters
        call_user_func_array([$controller, $method], $params);
    }

    /**
     * Handle 404 - Not Found
     */
    private function handleNotFound(): void
    {
        http_response_code(404);

        if (file_exists(VIEW_PATH . '/errors/404.php')) {
            require VIEW_PATH . '/errors/404.php';
        } else {
            echo '<h1>404 - Page Not Found</h1>';
            echo '<p>The page you are looking for does not exist.</p>';
        }
    }

    /**
     * Generate URL for a named route
     * 
     * @param string $path Route path
     * @param array $params Parameters to replace
     * @return string
     */
    public function url(string $path, array $params = []): string
    {
        foreach ($params as $key => $value) {
            $path = str_replace('{' . $key . '}', $value, $path);
        }

        return $this->basePath . $path;
    }
}
