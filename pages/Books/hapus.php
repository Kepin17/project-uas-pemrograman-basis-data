<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "DELETE FROM buku WHERE id_buku = $id";
    
    if ($conn->query($query)) {
        echo "<script>
                alert('Buku berhasil dihapus!');
                window.location.href = '?page=books';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
              </script>";
    }
}
?>
