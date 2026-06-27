<?php
/**
 * Front Controller
 * Entry point for all application requests
 */

// Start session
session_start();

// Define constants
define('BASE_PATH', dirname(__FILE__));
define('BASE_URL', '/faculty_website/');

// Require base classes
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Model.php';

// Composer autoload if available
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Custom autoloader for our classes
spl_autoload_register(function($class) {
    // PSR-4 style autoloading
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';
    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        // If not namespaced with our prefix, try traditional path
        $file = '';

        if (strpos($class, '\\') !== false) {
            // Namespaced class
            $ns = str_replace('\\', '/', $class);
            $file = $base_dir . $ns . '.php';
        } else {
            // Non-namespaced class - map to appropriate directory
            if ($class === 'Controller' || $class === 'Model') {
                // Already loaded manually, so skip
                $file = '';
            } elseif (strpos($class, 'Core') !== false) {
                $file = 'core/' . $class . '.php';
            } elseif (substr($class, -10) === 'Controller') { // ends with 'Controller'
                $file = 'controllers/' . $class . '.php';
            } else {
                // Default to models directory for other classes (e.g., User, Department, Teacher)
                $file = 'models/' . $class . '.php';
            }

            if ($file) {
                $file = __DIR__ . '/' . $file;
            }
        }

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Load configuration
require_once __DIR__ . '/config/database.php';

// Initialize router
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove base URL and query string
$uri = str_replace(BASE_URL, '', $uri);
$uri = explode('?', $uri)[0];
$uri = rtrim($uri, '/');

// Default route
if (empty($uri) || $uri === '/') {
    $uri = 'home';
}

// Split URI into parts
$uri_parts = explode('/', $uri);

// Controller name (first part, capitalize first letter)
$controller_name = ucfirst($uri_parts[0] ?? 'Home') . 'Controller';

// Method name (second part, default to 'index')
$method = $uri_parts[1] ?? 'index';

// Parameters (everything else)
$params = array_slice($uri_parts, 2);

// Instantiate controller and call method
if (class_exists($controller_name)) {
    $controller = new $controller_name();
    if (method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], $params);
    } else {
        // Method not found - show 404
        http_response_code(404);
        require_once __DIR__ . '/views/errors/404.php';
    }
} else {
    // Controller not found - show 404
    http_response_code(404);
    require_once __DIR__ . '/views/errors/404.php';
}
?>