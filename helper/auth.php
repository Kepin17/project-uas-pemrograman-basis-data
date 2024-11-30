<?php
class Auth {
    
    private $db;

    public function __construct($dbConn)
    {
        $this->db = $dbConn;
    }

    public function register($data, $type="anggota") {
        
        if($type == "anggota") {
            $sql = "INSERT INTO anggota (id_anggota, nama_anggota, alamat, nomor_telp, email) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param(
                "sssss",
                $data["id_anggota"],
                $data["nama_anggota"],
                $data["alamat"],
                $data["nomor_telp"],
                $data["email"],
            );
        }else if($type=="petugas") {
            $sql = "INSERT INTO petugas (id_petugas, nama_petugas, nomor_telp, email, id_jabatan) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param(
                "sssss",
                $data["id_petugas"],
                $data["nama_petugas"],
                $data["nomor_telp"],
                $data["email"],
                $data["id_jabatan"],
            );
        }else {
            return false;
        }

        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>