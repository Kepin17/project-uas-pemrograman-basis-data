<?php 
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "manajemen_perpustakaan";

$conn = new mysqli($host, $user, $pass, $dbname);

if($conn->connect_error) return die("Connection failed: " . $conn->connect_error);
?>