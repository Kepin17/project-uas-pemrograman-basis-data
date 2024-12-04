<?php
// Get the current page from URL parameter
$currentPage = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Define the content file path based on the current page
switch ($currentPage) {
    case 'dashboard':
        $content = __DIR__ . '/content/dashboard/index.php';
        $title = 'Dashboard';
        break;
    case 'books':
        $content = __DIR__ . '/content/books/index.php';
        $title = 'Books Management';
        break;
    case 'staff':
        $content = __DIR__ . '/content/staff/index.php';
        $title = 'Staff Management';
        break;

    case 'member':
        $content = __DIR__ . '/content/users/index.php';
        $title = 'Member Management';
        break;    
    case 'transactions':
        $content = __DIR__ . '/content/transactions/index.php';
        $title = 'Transaction Management';
        break;
    default:
        $content = __DIR__ . '/content/dashboard/index.php';
        $title = 'Dashboard';
}

// Include the layout
include_once(__DIR__ . '/../../components/layouts/adminLayouts.php');
