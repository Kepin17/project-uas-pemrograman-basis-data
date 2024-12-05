<?php
session_start();
require_once __DIR__ . '/config/config.php';

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Define routes with absolute paths
$routes = [
    '' => __DIR__ . '/pages/Dashboard/dashboard.php',
    'dashboard' => __DIR__ . '/pages/Dashboard/dashboard.php',
    'books' => __DIR__ . '/pages/Books/books.php',
    'categories' => __DIR__ . '/pages/Categories/categories.php',
    'shelves' => __DIR__ . '/pages/Shelves/shelves.php',
    'borrowing' => __DIR__ . '/pages/Borrowing/borrowing.php',
    'returning' => __DIR__ . '/pages/Returning/returning.php',
    'members' => __DIR__ . '/pages/Members/members.php',
    'staff' => __DIR__ . '/pages/Staff/staff.php',
    'login' => __DIR__ . '/pages/Auth/Login/login.php',
    'login_process.php' => __DIR__ . '/pages/Auth/Login/login_process.php',
    'logout' => __DIR__ . '/pages/Auth/Login/logout.php'
];

// Get the requested URL
$request_uri = $_SERVER['REQUEST_URI'];
$base_url_path = parse_url(BASE_URL, PHP_URL_PATH);
$path = str_replace($base_url_path, '', $request_uri);
$path = trim($path, '/');

// Remove query string if present
if (($pos = strpos($path, '?')) !== false) {
    $path = substr($path, 0, $pos);
}

// If path is empty, set to default
if (empty($path)) {
    $path = '';
}

// Check if the route exists
if (array_key_exists($path, $routes)) {
    $page = $routes[$path];
    
    // Skip authentication check for login-related pages
    $public_pages = ['login', 'login_process.php'];
    
    // Check if user needs to be logged in for this page
    if (!in_array($path, $public_pages) && !isLoggedIn()) {
        // Redirect to login page
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
    
    // If it's the login page and user is already logged in, redirect to dashboard
    if ($path === 'login' && isLoggedIn()) {
        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    }
    
    // Include the page
    require_once $page;
} else {
    // Handle 404
    http_response_code(404);
    echo '404 - Page Not Found';
}
?>
