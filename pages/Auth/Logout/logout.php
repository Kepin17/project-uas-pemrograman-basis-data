<?php
session_start();

$_SESSION = array();

if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/', '', true, true);
    unset($_COOKIE['remember_me']);
}

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

session_destroy();

header("Location: " . BASE_URL . "/login");
exit();
?>
