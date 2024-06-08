<?php
session_start();
require_once 'config.php'; 

// Fungsi untuk membersihkan input
function cleanInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = cleanInput($_POST["email"]);
    $password = cleanInput($_POST["password"]);

    // Cek koneksi ke database
    $conn = new mysqli("localhost", "root", "", "klasifikasi_hewan");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mendapatkan informasi admin berdasarkan email
    $sql = "SELECT * FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $row["password"])) {
            // Password benar, buat sesi dan alihkan ke halaman lain
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $email;
            header("Location: asli.php");
        } else {
            // Password salah
            echo "Password salah.";
        }
    } else {
        // Email tidak ditemukan
        echo "Email tidak ditemukan.";
    }

    $stmt->close();
    $conn->close();
}
?>
