<?php
if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $isbn = $_POST['isbn'];
    $penulis = $_POST['penulis'];
    $tahun = $_POST['tahun'];
    $kategori_id = $_POST['kategori_id'];
    $rak_id = $_POST['rak_id'];
    $stok = $_POST['stok'];

    $query = "INSERT INTO buku (judul, isbn, penulis, tahun_terbit, kategori_id, rak_id, stok) 
              VALUES ('$judul', '$isbn', '$penulis', '$tahun', $kategori_id, $rak_id, $stok)";
    
    if ($conn->query($query)) {
        echo "<script>
                alert('Buku berhasil ditambahkan!');
                window.location.href = '?page=books';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
              </script>";
    }
}
?>
