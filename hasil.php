<?php
session_start();

if (isset($_SESSION['explanation'])) {
    $explanation = $_SESSION['explanation'];
    unset($_SESSION['explanation']); // Hapus variabel dari sesi setelah digunakan
} else {
    // Redirect jika tidak ada penjelasan hasil yang diteruskan
    header("Location: proses_form.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Klasifikasi</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .table th, .table td {
            font-size: 16px;
        }
        .table thead th {
            background-color: #007bff;
            color: #fff;
        }
        .table tbody tr:hover {
            background-color: #cce5ff;
        }
        .result-table th, .result-table td {
            font-size: 18px;
            font-weight: bold;
        }
        .result-table .prob {
            color: #007bff;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?> <!-- Menyertakan file navbar.php -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Hasil Klasifikasi</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-bordered">
                    <thead class="thead-blue">
                        <tr>
                            <th>Gejala</th>
                            <th>Probabilitas Yes</th>
                            <th>Probabilitas No</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Symptom 1: <?php echo $explanation['symptom1']['value']; ?></td>
                            <td><?php echo $explanation['symptom1']['prob_yes']; ?></td>
                            <td><?php echo $explanation['symptom1']['prob_no']; ?></td>
                        </tr>
                        <tr>
                            <td>Symptom 2: <?php echo $explanation['symptom2']['value']; ?></td>
                            <td><?php echo $explanation['symptom2']['prob_yes']; ?></td>
                            <td><?php echo $explanation['symptom2']['prob_no']; ?></td>
                        </tr>
                        <tr>
                            <td>Symptom 3: <?php echo $explanation['symptom3']['value']; ?></td>
                            <td><?php echo $explanation['symptom3']['prob_yes']; ?></td>
                            <td><?php echo $explanation['symptom3']['prob_no']; ?></td>
                        </tr>
                        <tr>
                            <td>Symptom 4: <?php echo $explanation['symptom4']['value']; ?></td>
                            <td><?php echo $explanation['symptom4']['prob_yes']; ?></td>
                            <td><?php echo $explanation['symptom4']['prob_no']; ?></td>
                        </tr>
                        <tr>
                            <td>Symptom 5: <?php echo $explanation['symptom5']['value']; ?></td>
                            <td><?php echo $explanation['symptom5']['prob_yes']; ?></td>
                            <td><?php echo $explanation['symptom5']['prob_no']; ?></td>
                        </tr>
                    </tbody>
                </table>
                <h3 class="text-center mb-3">Probabilitas:</h3>
                <table class="table result-table">
                    <tbody>
                        <tr>
                            <td>Probabilitas Yes:</td>
                            <td class="prob"><?php echo $explanation['prob_yes']; ?></td>
                        </tr>
                        <tr>
                            <td>Probabilitas No:</td>
                            <td class="prob"><?php echo $explanation['prob_no']; ?></td>
                        </tr>
                        <tr>
                            <td>Klasifikasi:</td>
                            <td class="prob"><?php echo $explanation['classification']; ?></td>
                        </tr>
                    </tbody>
                </table>
              
            </div>
        </div>
    </div>
</body>
</html>
