<?php
session_start();
require_once 'config.php'; 


    function registerUser($nama, $alamat, $email, $password) {
        // Koneksi ke database
        $conn = new mysqli("localhost", "root", "", "klasifikasi_hewan");
    
        // Periksa koneksi
        if($conn->connect_error){
            die("ERROR: Could not connect. " . $conn->connect_error);
        }
    
        // Enkripsi password sebelum disimpan ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Persiapkan pernyataan SQL
        $sql = "INSERT INTO admin (nama, alamat, email, password) VALUES (?, ?, ?, ?)";
    
        // Persiapkan pernyataan yang akan dieksekusi
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nama, $alamat, $email, $hashed_password);
    
        // Eksekusi pernyataan
        if($stmt->execute()) {
            // Registrasi berhasil
            echo "Registrasi berhasil.";
            // Redirect ke halaman login.php setelah registrasi berhasil
            header("Location: login.php");
        } else {
            // Registrasi gagal
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        // Tutup koneksi
        $stmt->close();
        $conn->close();
    }
    
    // Contoh penggunaan function
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST["nama"];
        $alamat = $_POST["alamat"];
        $email = $_POST["email"];
        $password = $_POST["password"];
    
        // Panggil function registerUser
        registerUser($nama, $alamat, $email, $password);
    }


?>
