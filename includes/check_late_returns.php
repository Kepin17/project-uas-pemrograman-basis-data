<?php
require_once(__DIR__ . '/../config/connection.php');

function updateLateReturns() {
    global $conn;
    
    $query = "UPDATE peminjaman 
              SET status = 'TERLAMBAT' 
              WHERE estimasi_pinjam < CURRENT_DATE 
              AND status = 'DIPINJAM'";
              
    return mysqli_query($conn, $query);
}
