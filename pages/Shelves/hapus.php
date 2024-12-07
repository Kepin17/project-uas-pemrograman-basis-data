<?php
require "config/connection.php";

$id = $_GET['id'];
$query = "DELETE FROM rak_buku WHERE kode_rak = '$id'";
$conn->query($query) or die(mysqli_error($conn));
header("Location: " . BASE_URL . "/shelves");
?>
