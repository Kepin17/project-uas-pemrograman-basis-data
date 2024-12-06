<?php
require "config/connection.php";

$id = $_GET['id'];
$query = "DELETE FROM anggota WHERE id_anggota = '$id'";
$conn->query($query) or die(mysqli_error($conn));
header("Location: " . BASE_URL . "/members");
?>
