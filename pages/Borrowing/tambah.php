<?php
if (isset($_POST['submit'])) {
    $member_id = $_POST['member_id'];
    $buku_id = $_POST['buku_id'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $staff_id = $_POST['staff_id'];
    $status = 'Dipinjam';

    $query = "INSERT INTO peminjaman (member_id, buku_id, tanggal_pinjam, tanggal_kembali, staff_id, status) 
              VALUES ($member_id, $buku_id, '$tanggal_pinjam', '$tanggal_kembali', $staff_id, '$status')";
    
    if ($conn->query($query)) {
        // Update stok buku
        $conn->query("UPDATE buku SET stok = stok - 1 WHERE id_buku = $buku_id");
        
        echo "<script>
                alert('Peminjaman berhasil ditambahkan!');
                window.location.href = '?page=borrowing';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
              </script>";
    }
}
?>
