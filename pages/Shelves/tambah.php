<?php
if (isset($_POST['submit'])) {
    $nama_rak = $_POST['nama_rak'];
    $lokasi = $_POST['lokasi'];
    $kapasitas = $_POST['kapasitas'];

    $query = "INSERT INTO rak (nama_rak, lokasi, kapasitas) 
              VALUES ('$nama_rak', '$lokasi', $kapasitas)";
    
    if ($conn->query($query)) {
        echo "<script>
                alert('Rak berhasil ditambahkan!');
                window.location.href = '?page=shelves';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
              </script>";
    }
}
?>
