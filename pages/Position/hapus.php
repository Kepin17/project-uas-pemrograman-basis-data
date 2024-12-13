<?php
require "config/connection.php";

$id = $_GET['id'];
$query = "DELETE FROM jabatan WHERE id_jabatan = '$id'";
$conn->query($query) or die(mysqli_error($conn));
$conn->query($query) or die(mysqli_error($conn));
if ($conn->query($query)) {
    header("Location: " . BASE_URL . "/position?success=menghapus jabatan"); // Redirect ke halaman utama
    exit;
} else {
    die("Gagal menambahkan jabatan: " . $conn->error);
}
?>
