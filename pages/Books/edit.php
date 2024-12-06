<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $conn->query("SELECT * FROM buku WHERE id_buku = $id");
    $buku = $query->fetch_assoc();

    if (isset($_POST['submit'])) {
        $judul = $_POST['judul'];
        $isbn = $_POST['isbn'];
        $penulis = $_POST['penulis'];
        $tahun = $_POST['tahun'];
        $kategori_id = $_POST['kategori_id'];
        $rak_id = $_POST['rak_id'];
        $stok = $_POST['stok'];

        $query = "UPDATE buku 
                 SET judul = '$judul',
                     isbn = '$isbn',
                     penulis = '$penulis',
                     tahun_terbit = '$tahun',
                     kategori_id = $kategori_id,
                     rak_id = $rak_id,
                     stok = $stok
                 WHERE id_buku = $id";
        
        if ($conn->query($query)) {
            echo "<script>
                    alert('Buku berhasil diupdate!');
                    window.location.href = '?page=books';
                  </script>";
        } else {
            echo "<script>
                    alert('Error: " . $conn->error . "');
                  </script>";
        }
    }
}
?>
