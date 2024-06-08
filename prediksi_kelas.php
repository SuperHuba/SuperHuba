<?php
// Fungsi untuk mendapatkan data hewan dari tabel preprocesseddataset
function getAnimalData($conn) {
    $sql = "SELECT DISTINCT AnimalName, AnimalName FROM preprocesseddataset";
    $result = $conn->query($sql);
    $animals = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $animals[] = $row;
        }
    }
    return $animals;
}

// Fungsi untuk mendapatkan nilai simptom yang unik dari database
function getUniqueSymptoms($conn) {
    $sql = "SELECT DISTINCT Symptom1, Symptom2, Symptom3, Symptom4, Symptom5 FROM preprocesseddataset";
    $result = $conn->query($sql);
    $symptoms = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            foreach ($row as $symptom) {
                $symptoms[] = $symptom;
            }
        }
    }
    return array_unique($symptoms);
}

// Fungsi untuk menampilkan dropdown pilihan hewan kepada pengguna
function displayAnimalDropdown($animals) {
    echo "<label for='animal'>Pilih Hewan:</label>";
    echo "<select name='animal' id='animal' class='form-control'>";
    foreach ($animals as $animal) {
        echo "<option value='" . htmlspecialchars($animal['AnimalID']) . "'>" . htmlspecialchars($animal['AnimalName']) . "</option>";
    }
    echo "</select>";
}

// Fungsi untuk menampilkan dropdown pilihan simptom kepada pengguna
function displaySymptomDropdown($symptoms, $index) {
    echo "<label for='symptom$index'>Pilih Symptom $index:</label>";
    echo "<select name='symptom$index' id='symptom$index' class='form-control'>";
    foreach ($symptoms as $symptom) {
        echo "<option value='" . htmlspecialchars($symptom) . "'>" . htmlspecialchars($symptom) . "</option>";
    }
    echo "</select>";
}

// Koneksi ke database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "klasifikasi_hewan";

$conn = new mysqli("localhost", "root", "", "klasifikasi_hewan");

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan data hewan dari tabel preprocesseddataset
$animals = getAnimalData($conn);

// Mendapatkan nilai simptom yang unik dari database
$symptoms = getUniqueSymptoms($conn);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perhitungan</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="tabel.css">
  <style>
    .form-container {
      max-width: 700px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .form-group label {
      font-weight: bold;
    }
    .form-group select {
      margin-bottom: 15px;
    }
    .form-group input[type="submit"] {
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .form-group input[type="submit"]:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?> <!-- Menyertakan file navbar.php -->

<div class="container">
  <div class="form-container">
    <div class="form-header">
      <h2>Klasifikasi Penyakit Hewan</h2>
      <p>Silakan pilih hewan dan simptom yang sesuai untuk melakukan perhitungan</p>
    </div>
    <form action="proses_form.php" method="post">
      <div class="form-group">
        <?php
        // Menampilkan dropdown pilihan hewan
        displayAnimalDropdown($animals);
        ?>
      </div>
      <?php
      // Menampilkan dropdown pilihan simptom (maksimal 5)
      for ($i = 1; $i <= 5; $i++) {
          echo '<div class="form-group">';
          displaySymptomDropdown($symptoms, $i);
          echo '</div>';
      }
      ?>
      <div class="form-group text-left">
        <input type="submit" value="Hitung" class="btn btn-primary">
      </div>
    </form>
  </div>
</div>


<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
