<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar with Active State</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#"><i class="fas fa-paw"></i> Klasifikasi Penyakit Hewan</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <?php
      $currentPage = basename($_SERVER['PHP_SELF']);
      $navItems = [
          "asli.php" => "<i class='fas fa-database'></i> Data Asli",
          "preprocessing.php" => "<i class='fas fa-cogs'></i> Data Setelah Preprocessing",
          "pemodelan.php" => "<i class='fas fa-chart-pie'></i> Diagram",
          "prediksi_kelas.php" => "<i class='fas fa-predict'></i> Prediksi Kelas",
          "login.php" => "<i class='fas fa-sign-out-alt'></i> Logout"
      ];

      foreach ($navItems as $page => $label) {
          $activeClass = ($currentPage === $page) ? "active" : "";
          echo "<li class='nav-item $activeClass'>";
          echo "<a class='nav-link' href='$page'>$label</a>";
          echo "</li>";
      }
      ?>
    </ul>
  </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
