<?php
// Detect protocol (http/https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Get the host
$host = $_SERVER['HTTP_HOST'];

// Get the directory path after domain
$script_name = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

// Combine all parts
define('BASE_URL', $protocol . '://' . $host . $script_name);

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'manajemen_perpustakaan');
?>