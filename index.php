<?php
require_once "config/config.php";

// Get the request URI and remove BASE_URL
$req = $_SERVER['REQUEST_URI'];
$base_path = parse_url(BASE_URL, PHP_URL_PATH);
$req = str_replace($base_path, '', $req);
$req = trim($req, '/');

// Split URL into segments
$segments = !empty($req) ? explode('/', $req) : [''];
$page = $segments[0];

// Define valid routes
$routes = [
    '' => '/src/views/homePage.php',
    'register' => '/src/views/register.php',
];

// Check if route exists and load appropriate file
if (array_key_exists($page, $routes)) {
    $file_path = __DIR__ . $routes[$page];
    if (file_exists($file_path)) {
        require $file_path;
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "404 - File not found: {$routes[$page]}";
    }
} else {
    header("HTTP/1.0 404 Not Found");
    echo "404 - Page Not Found";
}
?>
