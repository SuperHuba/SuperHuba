<?php
// Konfigurasi database
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'klasifikasi_hewan');

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "klasifikasi_hewan");

// Cek koneksi
if($conn->connect_error){
    die("ERROR: Could not connect. " . $conn->connect_error);
}
?>
