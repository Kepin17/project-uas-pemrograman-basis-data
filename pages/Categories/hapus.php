<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "DELETE FROM kategori WHERE id_kategori = $id";
    
    if ($conn->query($query)) {
        echo "<script>
                alert('Kategori berhasil dihapus!');
                window.location.href = '?page=categories';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
              </script>";
    }
}
?>
