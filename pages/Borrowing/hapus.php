<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil data peminjaman untuk mengembalikan stok buku
    $query = $conn->query("SELECT buku_id FROM peminjaman WHERE id_peminjaman = $id");
    $peminjaman = $query->fetch_assoc();
    
    // Update stok buku
    $conn->query("UPDATE buku SET stok = stok + 1 WHERE id_buku = " . $peminjaman['buku_id']);
    
    $query = "DELETE FROM peminjaman WHERE id_peminjaman = $id";
    
    if ($conn->query($query)) {
        echo "<script>
                alert('Peminjaman berhasil dihapus!');
                window.location.href = '?page=borrowing';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
              </script>";
    }
}
?>
