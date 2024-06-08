<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Sebelum preProcessing</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="tabel.css">
 
</head>
<body>
<?php include 'navbar.php'; ?> <!-- Menyertakan file navbar.php -->
<div class="container mt-4">
  <h2>Data Sebelum preProcessing</h2>
  <a href="#" class="btn btn-primary mb-3">Kembali halaman utama</a>
  <?php
  // Koneksi ke database
  $koneksi = new mysqli("localhost", "root", "", "klasifikasi_hewan");

  // Query untuk mengambil data dari tabel Dataset
  $query = "SELECT * FROM Dataset";
  $result = $koneksi->query($query);

  // Mengecek apakah query berhasil dieksekusi
  if ($result) {
      if ($result->num_rows > 0) {
          // Memulai tabel HTML
          echo "<table>";
          echo "<tr><th>No</th><th>AnimalName</th><th>Symptom1</th><th>Symptom2</th><th>Symptom3</th><th>Symptom4</th><th>Symptom5</th><th>Dangerous</th></tr>";

          // Menampilkan data dalam bentuk baris tabel
          while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row["AnimalID"] . "</td>";
              echo "<td>" . $row["AnimalName"] . "</td>";
              echo "<td>" . $row["Symptom1"] . "</td>";
              echo "<td>" . $row["Symptom2"] . "</td>";
              echo "<td>" . $row["Symptom3"] . "</td>";
              echo "<td>" . $row["Symptom4"] . "</td>";
              echo "<td>" . $row["Symptom5"] . "</td>";
              echo "<td>" . $row["Dangerous"] . "</td>";
              echo "</tr>";
          }

          // Menutup tabel HTML
          echo "</table>";
      } else {
          echo "Tidak ada data yang ditemukan.";
      }
  } else {
      echo "Error: " . $koneksi->error;
  }

  // Menutup koneksi
  $koneksi->close();
  ?>
</div>

</body>
</html>
