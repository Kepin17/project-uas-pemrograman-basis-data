<?php
require_once "config/config.php";
$req = trim($_SERVER['REQUEST_URI']);

$req = str_replace(BASE_URL, '', $req);


switch ($req) {
  case '/':
  case '':
    require __DIR__ . "/src/views/homePage.php";
    break;
  default:
    echo "404 - Page Not Found";
    break;
}

?>
