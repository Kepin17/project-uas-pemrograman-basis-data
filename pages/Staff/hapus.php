<?php
require "config/connection.php";

$id = $_GET['id'];
$query = "DELETE FROM petugas WHERE id_petugas = '$id'";
$conn->query($query) or die(mysqli_error($conn));
if ($conn->query($query)) {
  header("Location: " . BASE_URL . "/staff?success=menghapus staff");
  exit;
} else {
  die("Gagal menghapus staff: " . $conn->error);
}
?>
