<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Setelah preProcessing</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* CSS untuk mengatur lebar maksimum kolom tabel */
.table th,
.table td {
    max-width: 150px; 
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

  </style>
 
</head>
<body>
<?php include 'navbar.php'; ?> 
<div class="container mt-4">
<h2>Data Setelah preProcessing</h2>
  <a href="tampil.php" class="btn btn-primary mb-3">Kembali halaman utama</a>
<div class="row">
    <div class="col">
<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "klasifikasi_hewan");

// Fungsi untuk melakukan preprocessing data
function preprocessData($row) {
    // Case Folding: Mengubah teks menjadi huruf kecil semua
    $row["AnimalName"] = strtolower($row["AnimalName"]);
    $row["Symptom1"] = strtolower($row["Symptom1"]);
    $row["Symptom2"] = strtolower($row["Symptom2"]);
    $row["Symptom3"] = strtolower($row["Symptom3"]);
    $row["Symptom4"] = strtolower($row["Symptom4"]);
    $row["Symptom5"] = strtolower($row["Symptom5"]);
    $row["Dangerous"] = strtolower($row["Dangerous"]);

    // Word Normalization: Menghapus karakter non-alfanumerik dan mengubah ke format yang sesuai
    $row["AnimalName"] = preg_replace('/[^a-z0-9]+/', '', $row["AnimalName"]);
    $row["Symptom1"] = preg_replace('/[^a-z0-9]+/', '', $row["Symptom1"]);
    $row["Symptom2"] = preg_replace('/[^a-z0-9]+/', '', $row["Symptom2"]);
    $row["Symptom3"] = preg_replace('/[^a-z0-9]+/', '', $row["Symptom3"]);
    $row["Symptom4"] = preg_replace('/[^a-z0-9]+/', '', $row["Symptom4"]);
    $row["Symptom5"] = preg_replace('/[^a-z0-9]+/', '', $row["Symptom5"]);
    $row["Dangerous"] = preg_replace('/[^a-z0-9]+/', '', $row["Dangerous"]);

    // Whitespace Normalization: Menghapus whitespace yang berlebihan
    $row["AnimalName"] = preg_replace('/\s+/', ' ', $row["AnimalName"]);
    $row["Symptom1"] = preg_replace('/\s+/', ' ', $row["Symptom1"]);
    $row["Symptom2"] = preg_replace('/\s+/', ' ', $row["Symptom2"]);
    $row["Symptom3"] = preg_replace('/\s+/', ' ', $row["Symptom3"]);
    $row["Symptom4"] = preg_replace('/\s+/', ' ', $row["Symptom4"]);
    $row["Symptom5"] = preg_replace('/\s+/', ' ', $row["Symptom5"]);
    $row["Dangerous"] = preg_replace('/\s+/', ' ', $row["Dangerous"]);

    // Mengembalikan baris data yang telah diproses
    return $row;
}


// Query untuk mengambil data dari tabel Dataset
$query = "SELECT * FROM Dataset";
$result = $koneksi->query($query);

// Mengecek apakah query berhasil dieksekusi
if ($result) {
    if ($result->num_rows > 0) {
        // Memulai tabel HTML untuk menampilkan data setelah preprocessing      
        echo "<table class='table'>";
        echo "<thead class='thead-info'><tr><th scope='col'>No</th><th scope='col'>AnimalName</th><th scope='col'>Symptom1</th><th scope='col'>Symptom2</th><th scope='col'>Symptom3</th><th scope='col'>Symptom4</th><th scope='col'>Symptom5</th><th scope='col'>Dangerous</th></tr></thead><tbody>";


        // Looping melalui setiap baris data dari tabel Dataset
        while ($row = $result->fetch_assoc()) {
            // Memproses data dan menyimpannya ke dalam tabel baru
            $preprocessed_row = preprocessData($row);
            // Menyisipkan data yang telah diproses ke dalam tabel PreprocessedDataset
            $insert_query = "INSERT IGNORE INTO PreprocessedDataset (AnimalID, AnimalName, Symptom1, Symptom2, Symptom3, Symptom4, Symptom5, Dangerous) VALUES ('" . $preprocessed_row["AnimalID"] . "', '" . $preprocessed_row["AnimalName"] . "', '" . $preprocessed_row["Symptom1"] . "', '" . $preprocessed_row["Symptom2"] . "', '" . $preprocessed_row["Symptom3"] . "', '" . $preprocessed_row["Symptom4"] . "', '" . $preprocessed_row["Symptom5"] . "', '" . $preprocessed_row["Dangerous"] . "')";
            $koneksi->query($insert_query);

            // Menampilkan data setelah preprocessing
            echo "<tr>";
            echo "<td>" . $preprocessed_row["AnimalID"] . "</td>";
            echo "<td>" . $preprocessed_row["AnimalName"] . "</td>";
            echo "<td>" . $preprocessed_row["Symptom1"] . "</td>";
            echo "<td>" . $preprocessed_row["Symptom2"] . "</td>";
            echo "<td>" . $preprocessed_row["Symptom3"] . "</td>";
            echo "<td>" . $preprocessed_row["Symptom4"] . "</td>";
            echo "<td>" . $preprocessed_row["Symptom5"] . "</td>";
            echo "<td>" . $preprocessed_row["Dangerous"] . "</td>";
            echo "</tr>";
        }

        // Menutup tabel HTML
        echo "</tbody></table>";
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
</div>
</div>
</body>
</html>
