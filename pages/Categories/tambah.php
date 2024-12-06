<?php
if (isset($_POST['submit'])) {
    $nama_kategori = $_POST['nama_kategori'];
    $deskripsi = $_POST['deskripsi'];

    $query = "INSERT INTO kategori (nama_kategori, deskripsi) 
              VALUES ('$nama_kategori', '$deskripsi')";
    
    if ($conn->query($query)) {
        echo "<script>
                alert('Kategori berhasil ditambahkan!');
                window.location.href = '?page=categories';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
              </script>";
    }
}
?>
