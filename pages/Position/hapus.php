<?php
require "config/connection.php";

$id = $_GET['id'];
$query = "DELETE FROM jabatan WHERE id_jabatan = '$id'";
$conn->query($query) or die(mysqli_error($conn));
header("Location: " . BASE_URL . "/position");
?>
