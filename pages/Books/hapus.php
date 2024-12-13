<?php
require "config/connection.php";

$id = $_GET['id'];
$query = "DELETE FROM buku WHERE id_buku = '$id'";
if ($conn->query($query)) {
  header("Location: " . BASE_URL . "/books?success=menghapus buku");
  exit;
} else {
  die("Gagal mengahpus buku: " . $conn->error);
}
?>
