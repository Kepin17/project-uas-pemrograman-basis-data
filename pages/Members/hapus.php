<?php
require "config/connection.php";

$id = $_GET['id'];
$query = "DELETE FROM anggota WHERE id_anggota = '$id'";
$conn->query($query) or die(mysqli_error($conn));
if ($conn->query($query)) {
  header("Location: " . BASE_URL . "/members?success=menghapus anggota");
  exit;
} else {
  die("Gagal menambahkan kategori: " . $conn->error);
}
?>
