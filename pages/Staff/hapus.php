<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "DELETE FROM staff WHERE id_staff = $id";
    
    if ($conn->query($query)) {
        echo "<script>
                alert('Staff berhasil dihapus!');
                window.location.href = '?page=staff';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
              </script>";
    }
}
?>
