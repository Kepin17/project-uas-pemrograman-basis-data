<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $conn->query("SELECT * FROM kategori WHERE id_kategori = $id");
    $kategori = $query->fetch_assoc();

    if (isset($_POST['submit'])) {
        $nama_kategori = $_POST['nama_kategori'];
        $deskripsi = $_POST['deskripsi'];

        $query = "UPDATE kategori 
                 SET nama_kategori = '$nama_kategori',
                     deskripsi = '$deskripsi'
                 WHERE id_kategori = $id";
        
        if ($conn->query($query)) {
            echo "<script>
                    alert('Kategori berhasil diupdate!');
                    window.location.href = '?page=categories';
                  </script>";
        } else {
            echo "<script>
                    alert('Error: " . $conn->error . "');
                  </script>";
        }
    }
}
?>
