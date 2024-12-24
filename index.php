<?php
session_start();
require_once __DIR__ . '/config/config.php';

// Debug session information
if (isset($_GET['debug']) && $_GET['debug'] === 'session') {
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
    exit();
}

$path = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION['id_petugas']) && $path === __DIR__ . '/') {
    header("Location: " . BASE_URL . "/login");
    exit();
}

// Define routes with absolute paths
$protected_routes = [
    '' => __DIR__ . '/pages/Dashboard/dashboard.php',
    'dashboard' => __DIR__ . '/pages/Dashboard/dashboard.php',
    'books' => __DIR__ . '/pages/Books/books.php',
    'books/addBook' => __DIR__ . '/pages/Books/tambah.php',
    'books/editBook' => __DIR__ . '/pages/Books/edit.php',
    'books/deleteBook' => __DIR__ . '/pages/Books/hapus.php',
    'categories' => __DIR__ . '/pages/Categories/categories.php',
    'categories/addCategory' => __DIR__ . '/pages/Categories/tambah.php',
    'categories/editCategory' => __DIR__ . '/pages/Categories/edit.php',
    'categories/deleteCategory' => __DIR__ . '/pages/Categories/hapus.php',
    'shelves' => __DIR__ . '/pages/Shelves/shelves.php',
    'shelves/addShelve' => __DIR__ . '/pages/Shelves/tambah.php',
    'shelves/editShelve' => __DIR__ . '/pages/Shelves/edit.php',
    'shelves/deleteShelve' => __DIR__ . '/pages/Shelves/hapus.php',
    'returning' => __DIR__ . '/pages/Pengembalian/pengembalian.php',
    'returning/pross' => __DIR__ . '/pages/Pengembalian/process_pengembalian.php',
    'members' => __DIR__ . '/pages/Members/members.php',
    'members/addMember' => __DIR__ . '/pages/Members/tambah.php',
    'members/editMember' => __DIR__ . '/pages/Members/edit.php',
    'members/deleteMember' => __DIR__ . '/pages/Members/hapus.php',
    'position' => __DIR__ . '/pages/Position/position.php',
    'position/addPosition' => __DIR__ . '/pages/Position/tambah.php',
    'position/editPosition' => __DIR__ . '/pages/Position/edit.php',
    'position/deletePosition' => __DIR__ . '/pages/Position/hapus.php',
    'staff' => __DIR__ . '/pages/Staff/staff.php',
    'staff/addStaff' => __DIR__ . '/pages/Staff/tambah.php',
    'staff/editStaff' => __DIR__ . '/pages/Staff/edit.php',
    'staff/deleteStaff' => __DIR__ . '/pages/Staff/hapus.php',
    'peminjaman' => __DIR__ . '/pages/Peminjaman/index.php',
    'peminjaman/process' => __DIR__ . '/pages/peminjaman/process.php',
    'logout' => __DIR__ . '/pages/Auth/Logout/logout.php',
];

function checkAuth() {
    if (!isset($_SESSION['id_petugas'])) {
        header("Location: " . BASE_URL . "/login");
        exit();
    }
}

$routes = [
    'login' => __DIR__ . '/pages/Auth/Login/login.php',
    'register' => __DIR__ . '/pages/Auth/Register/register.php', 
    'register/process' => __DIR__ . '/pages/Auth/Register/process_register.php', 
    'login/process' => __DIR__ . '/pages/Auth/Login/process_login.php',
    'login/forgot-password' => __DIR__ . '/pages/Auth/ForPass/forgot_pass.php',
    'login/verify-otp' => __DIR__ . '/pages/Auth/ForPass/verify-otp.php', 
    'login/reset-password' => __DIR__ . '/pages/Auth/ForPass/reset.php',
];

$request_uri = $_SERVER['REQUEST_URI'];
$base_url_path = parse_url(BASE_URL, PHP_URL_PATH);
$path = str_replace($base_url_path, '', $request_uri);
$path = trim($path, '/');

// Extract the base path without query parameters
$pathParts = explode('?', $path);
$basePath = $pathParts[0];

// If path is empty, set to default
if (empty($basePath)) {
    $basePath = '';
}

// Check if route needs authentication
if (array_key_exists($basePath, $protected_routes)) {
    checkAuth();
    $page = $protected_routes[$basePath];
    require_once $page;
} elseif (array_key_exists($basePath, $routes)) {
    if (isset($_SESSION['id_petugas'])  && ($basePath === 'login' || $basePath === '')) {
        header("Location: " . BASE_URL . "/dashboard");
        exit();
    }
    $page = $routes[$basePath];
    require_once $page;
} else {
    http_response_code(404);
    include __DIR__ . '/pages/errors/404.php';
}

// Add special handling for AJAX requests
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    
    if (array_key_exists($basePath, $protected_routes)) {
        checkAuth();
        require_once $protected_routes[$basePath];
        exit;
    }
}

// Handle POST requests for peminjaman
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($basePath) {
        case 'peminjaman/cart-process': // Updated case
            checkAuth();
            require_once $protected_routes['peminjaman/cart_process'];
            break;
            
        case 'peminjaman/process':
            checkAuth();
            require_once $protected_routes['peminjaman/process'];
            break;
            
        case 'peminjaman/add-to-cart':
            checkAuth();
            require_once $protected_routes['peminjaman/add-to-cart'];
            break;
            
        case 'peminjaman/remove-from-cart':
            checkAuth();
            require_once $protected_routes['peminjaman/remove-from-cart'];
            break;
            
        case 'peminjaman/clear-cart':
            checkAuth();
            require_once $protected_routes['peminjaman/clear-cart'];
            break;
    }
    exit;
}
?>
