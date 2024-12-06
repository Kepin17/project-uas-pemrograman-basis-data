<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $conn->query("SELECT * FROM staff WHERE id_staff = $id");
    $staff = $query->fetch_assoc();

    if (isset($_POST['submit'])) {
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $no_telp = $_POST['no_telp'];
        $alamat = $_POST['alamat'];
        $jabatan = $_POST['jabatan'];

        $query = "UPDATE staff 
                 SET nama = '$nama',
                     email = '$email',
                     no_telp = '$no_telp',
                     alamat = '$alamat',
                     jabatan = '$jabatan'
                 WHERE id_staff = $id";
        
        if ($conn->query($query)) {
            echo "<script>
                    alert('Staff berhasil diupdate!');
                    window.location.href = '?page=staff';
                  </script>";
        } else {
            echo "<script>
                    alert('Error: " . $conn->error . "');
                  </script>";
        }
    }
}
?>
