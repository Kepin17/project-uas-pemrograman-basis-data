<?php
// Get the current page from URL parameter
$currentPage = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Define the content file path based on the current page
switch ($currentPage) {
    case 'dashboard':
        $content = __DIR__ . '/content/dashboard.php';
        $title = 'Dashboard';
        break;
    case 'books':
        $content = __DIR__ . '/content/books.php';
        $title = 'Books Management';
        break;
    case 'users':
        $content = __DIR__ . '/content/users.php';
        $title = 'Users Management';
        break;
    case 'staff':
        $content = __DIR__ . '/content/staff.php';
        $title = 'Staff Management';
        break;
    default:
        $content = __DIR__ . '/content/dashboard.php';
        $title = 'Dashboard';
}

// Include the layout
include_once(__DIR__ . '/../../components/layouts/adminLayouts.php');
