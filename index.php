<?php
require_once "config/config.php";

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get the request URI and method
$req = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$base_path = parse_url(BASE_URL, PHP_URL_PATH);
$req = str_replace($base_path, '', $req);
$req = trim($req, '/');

// Split URL into segments
$segments = !empty($req) ? explode('/', $req) : [''];
$page = $segments[0];

// Define valid routes with their corresponding files and allowed methods
$routes = [
    '' => [
        'path' => '/src/views/home.view.php',
        'methods' => ['GET']
    ],
    'register' => [
        'path' => '/src/views/register.view.php',
        'methods' => ['GET', 'POST']
    ],
    'login' => [
        'path' => '/src/views/login.view.php',
        'methods' => ['GET', 'POST']
    ],
    
    'admin' => [
        'path' => '/src/pages/admin/index.php',
        'methods' => ['GET'],
        'auth' => false
    ],

    
    'logout' => [
        'path' => '/src/controllers/auth/logout.php',
        'methods' => ['GET']
    ]
];

// Function to check if user is authenticated
function isAuthenticated() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Handle routing
if (array_key_exists($page, $routes)) {
    $route = $routes[$page];
    
    // Check if the HTTP method is allowed
    if (!in_array($method, $route['methods'])) {
        http_response_code(405);
        include "src/views/405.view.php";
        exit;
    }
    
    // Check authentication if required
    if (isset($route['auth']) && $route['auth'] && !isAuthenticated()) {
        header('Location: ' . BASE_URL . 'login');
        exit;
    }
    
    $file_path = __DIR__ . $route['path'];
    if (file_exists($file_path)) {
        require $file_path;
    } else {
        http_response_code(404);
        include "src/views/404.view.php";
    }
} else {
    http_response_code(404);
    include "src/views/404.view.php";
}
?>
