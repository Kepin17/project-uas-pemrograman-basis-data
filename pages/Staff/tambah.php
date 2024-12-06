<?php
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $jabatan = $_POST['jabatan'];

    $query = "INSERT INTO staff (nama, email, no_telp, alamat, jabatan) 
              VALUES ('$nama', '$email', '$no_telp', '$alamat', '$jabatan')";
    
    if ($conn->query($query)) {
        echo "<script>
                alert('Staff berhasil ditambahkan!');
                window.location.href = '?page=staff';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
              </script>";
    }
}
?>
