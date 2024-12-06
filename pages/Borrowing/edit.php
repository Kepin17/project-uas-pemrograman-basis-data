<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $conn->query("SELECT * FROM peminjaman WHERE id_peminjaman = $id");
    $peminjaman = $query->fetch_assoc();

    if (isset($_POST['submit'])) {
        $member_id = $_POST['member_id'];
        $buku_id = $_POST['buku_id'];
        $tanggal_pinjam = $_POST['tanggal_pinjam'];
        $tanggal_kembali = $_POST['tanggal_kembali'];
        $staff_id = $_POST['staff_id'];
        $status = $_POST['status'];

        // Jika buku yang dipinjam berubah, perlu update stok
        if ($buku_id != $peminjaman['buku_id']) {
            $conn->query("UPDATE buku SET stok = stok + 1 WHERE id_buku = " . $peminjaman['buku_id']);
            $conn->query("UPDATE buku SET stok = stok - 1 WHERE id_buku = $buku_id");
        }

        $query = "UPDATE peminjaman 
                 SET member_id = $member_id,
                     buku_id = $buku_id,
                     tanggal_pinjam = '$tanggal_pinjam',
                     tanggal_kembali = '$tanggal_kembali',
                     staff_id = $staff_id,
                     status = '$status'
                 WHERE id_peminjaman = $id";
        
        if ($conn->query($query)) {
            echo "<script>
                    alert('Peminjaman berhasil diupdate!');
                    window.location.href = '?page=borrowing';
                  </script>";
        } else {
            echo "<script>
                    alert('Error: " . $conn->error . "');
                  </script>";
        }
    }
}
?>
