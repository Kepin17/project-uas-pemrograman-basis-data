<?php
require "config/connection.php";

$id = $_GET['id'];
$query = "DELETE FROM kategori_buku WHERE id_kategori = '$id'";
$conn->query($query) or die(mysqli_error($conn));
if ($conn->query($query)) {
  header("Location: " . BASE_URL . "/categories?success=menghapus kategori");
  exit;
} else {
  die("Gagal menambahkan buku: " . $conn->error);
}
?>
