<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "DELETE FROM rak WHERE id_rak = $id";
    
    if ($conn->query($query)) {
        echo "<script>
                alert('Rak berhasil dihapus!');
                window.location.href = '?page=shelves';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
              </script>";
    }
}
?>
