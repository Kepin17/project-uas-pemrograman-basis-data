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

// get current Page
$request_uri = $_SERVER['REQUEST_URI'];
$base_url_path = parse_url(BASE_URL, PHP_URL_PATH);
$current_path = str_replace($base_url_path, '', $request_uri);
$current_path = trim($current_path, '/');

// If it's the home page or empty path, set to index
if (empty($current_path)) {
    $current_path = 'index';
}

define('CURRENT_PAGE', $current_path);

require_once "app_config.php"
?>