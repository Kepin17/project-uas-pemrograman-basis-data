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
    'shelves/addShelve' => __DIR__ . '/pages/Shelves/tambah.php',
    'shelves/editShelve' => __DIR__ . '/pages/Shelves/edit.php',
    'shelves/deleteShelve' => __DIR__ . '/pages/Shelves/hapus.php',
    'borrowing' => __DIR__ . '/pages/Borrowing/borrowing.php',
    'returning' => __DIR__ . '/pages/Pengembalian/pengembalian.php',
    'members' => __DIR__ . '/pages/Members/members.php',
    'members/addMember' => __DIR__ . '/pages/Members/tambah.php',
    'members/editMember' => __DIR__ . '/pages/Members/edit.php',
    'members/deleteMember' => __DIR__ . '/pages/Members/hapus.php',
    'staff' => __DIR__ . '/pages/Staff/staff.php',
    'login' => __DIR__ . '/pages/Auth/Login/login.php',
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
    
    // Include the page
    require_once $page;
} else {
    // Handle 404
    http_response_code(404);
    include __DIR__ . '/pages/errors/404.php';
}
?>
