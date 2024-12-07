<?php
require "config/connection.php";

$id = $_GET['id'];
$query = "DELETE FROM kategori_buku WHERE id_kategori = '$id'";
$conn->query($query) or die(mysqli_error($conn));
header("Location: " . BASE_URL . "/categories");
?>
