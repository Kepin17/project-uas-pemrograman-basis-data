<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $conn->query("SELECT * FROM rak WHERE id_rak = $id");
    $rak = $query->fetch_assoc();

    if (isset($_POST['submit'])) {
        $nama_rak = $_POST['nama_rak'];
        $lokasi = $_POST['lokasi'];
        $kapasitas = $_POST['kapasitas'];

        $query = "UPDATE rak 
                 SET nama_rak = '$nama_rak',
                     lokasi = '$lokasi',
                     kapasitas = $kapasitas
                 WHERE id_rak = $id";
        
        if ($conn->query($query)) {
            echo "<script>
                    alert('Rak berhasil diupdate!');
                    window.location.href = '?page=shelves';
                  </script>";
        } else {
            echo "<script>
                    alert('Error: " . $conn->error . "');
                  </script>";
        }
    }
}
?>
