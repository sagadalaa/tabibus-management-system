<?php
/**
 * Routes Configuration for Clinic Management System
 * Author: Your Name
 * Description: Defines the URL-to-controller mappings for the application.
 */

// Load required configuration and helpers
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/../helpers/functions.php';

// Define your routes as an associative array
$routes = [
    '/' => [
        'controller' => 'DashboardController',
        'method' => 'index',
        'middleware' => ['auth'],
    ],
    '/login' => [
        'controller' => 'AuthController',
        'method' => 'loginForm',
    ],
    '/logout' => [
        'controller' => 'AuthController',
        'method' => 'logout',
    ],
    '/register' => [
        'controller' => 'AuthController',
        'method' => 'registerForm',
    ],
    '/patients' => [
        'controller' => 'PatientController',
        'method' => 'list',
        'middleware' => ['auth', 'role:clinic_admin'],
    ],
    '/appointments' => [
        'controller' => 'AppointmentController',
        'method' => 'list',
        'middleware' => ['auth'],
    ],
    '/services' => [
        'controller' => 'ServiceController',
        'method' => 'index',
        'middleware' => ['auth', 'role:clinic_admin'],
    ],
    '/reports' => [
        'controller' => 'ReportController',
        'method' => 'index',
        'middleware' => ['auth', 'role:clinic_admin'],
    ],
    '/system' => [
        'controller' => 'SystemController',
        'method' => 'index',
        'middleware' => ['auth', 'role:clinic_admin'],
    ],
    '/messages' => [
        'controller' => 'MessagingController',
        'method' => 'index',
        'middleware' => ['auth'],
    ],
];

// Handle the current request URI
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Match the request URI to a defined route or use a fallback
if (isset($routes[$requestUri])) {
    $route = $routes[$requestUri];
    $controllerName = $route['controller'];
    $methodName = $route['method'];

    // Check for middleware (e.g., authentication, role-based access)
    if (isset($route['middleware'])) {
        foreach ($route['middleware'] as $middleware) {
            if (!handleMiddleware($middleware)) {
                // Middleware failed, redirect to login or error page
                redirect('/login');
                exit;
            }
        }
    }

    // Load and execute the controller method
    $controllerFile = __DIR__ . "/../controllers/{$controllerName}.php";
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controller = new $controllerName();
        if (method_exists($controller, $methodName)) {
            call_user_func([$controller, $methodName]);
        } else {
            http_response_code(404);
            echo "Method not found: {$methodName}";
        }
    } else {
        http_response_code(404);
        echo "Controller not found: {$controllerName}";
    }
} else {
    // Route not found, show a 404 page
    http_response_code(404);
    echo "Page not found.";
}

/**
 * Middleware Handler
 * @param string $middleware The middleware name (e.g., 'auth', 'role:clinic_admin').
 * @return bool True if middleware passes, false otherwise.
 */
function handleMiddleware($middleware)
{
    if ($middleware === 'auth') {
        // Example: Check if the user is authenticated
        return isset($_SESSION['user_id']);
    }

    if (strpos($middleware, 'role:') === 0) {
        // Example: Check if the user has a specific role
        $requiredRole = explode(':', $middleware)[1];
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $requiredRole;
    }

    return true; // Default pass for unknown middleware
}
