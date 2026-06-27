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
// Debug: log to file
error_log("BASE_URL defined: " . BASE_URL, 3, __DIR__ . '/baseurl.log');

// Require base classes
require_once __DIR__ . '/Core/Controller.php';
require_once __DIR__ . '/Models/Model.php';

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
            } elseif (strpos($class, 'core') !== false) {
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

// Define explicit routes
$routes = [
    '' => ['controller' => 'HomeController', 'method' => 'index'],
    'login' => ['controller' => 'LoginController', 'method' => 'login'],
    'register' => ['controller' => 'LoginController', 'method' => 'register'],
    'logout' => ['controller' => 'LoginController', 'method' => 'logout'],
    'profile' => ['controller' => 'LoginController', 'method' => 'profile'],
];

// Check if the URI matches an explicit route
if (array_key_exists($uri, $routes)) {
    $controller_name = $routes[$uri]['controller'];
    $method = $routes[$uri]['method'];
    $params = []; // No parameters for explicit routes
} else {
    // Split URI into parts
    $uri_parts = explode('/', $uri);

    // Controller name (first part, capitalize first letter)
    $controller_name = ucfirst($uri_parts[0] ?? 'Home') . 'Controller';

    // Method name (second part, default to 'index')
    $method = $uri_parts[1] ?? 'index';

    // If method is 'index', derive action from controller name (e.g., LoginController -> login)
    if ($method === 'index') {
        // Remove 'Controller' suffix and lowercase to get action name
        $action = substr($controller_name, 0, -10); // remove 'Controller'
        $method = strtolower($action);
    }

    // Parameters (everything else)
    $params = array_slice($uri_parts, 2);
}

// Debug: log route details
error_log("Request URI: " . $_SERVER['REQUEST_URI'] . ", BASE_URL: " . BASE_URL . ", processed uri: '" . $uri . "', uri_parts: " . json_encode($uri_parts ?? []) . ", controller: $controller_name, method: $method" . PHP_EOL, 3, __DIR__ . '/router.log');

// Instantiate controller and call method
error_log("Route: controller=$controller_name, method=$method" . PHP_EOL, 3, __DIR__ . '/router.log');
if (class_exists($controller_name)) {
    error_log("Controller $controller_name exists", 3, __DIR__ . '/router.log');
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
    error_log("Controller $controller_name does not exist", 3, __DIR__ . '/router.log');
    http_response_code(404);
    require_once __DIR__ . '/views/errors/404.php';
}