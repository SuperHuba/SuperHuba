<?php
session_start();


if (isset($_SESSION['explanation']) && isset($_SESSION['metrics'])) {
    $explanation = $_SESSION['explanation'];
    $metrics = $_SESSION['metrics'];
    unset($_SESSION['explanation']); 
    unset($_SESSION['metrics']); 
} else {
   
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
        .table-custom th, .table-custom td {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            text-align: center;
        }
        .table-custom tr:nth-child(even) {
            background-color: #e3f2fd;
        }
        .table-custom th {
            background-color: #007bff;
            color: white;
        }
    </style>
    <!-- Tambahkan CSS untuk grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include 'navbar.php'; ?> <!-- Menyertakan file navbar.php -->
    <div class="container mt-5">
        <h1>Hasil Klasifikasi</h1>
        <table class="table table-bordered table-custom">
            <thead>
                <tr>
                    <th>Gejala</th>
                    <th>Probabilitas Yes</th>
                    <th>Probabilitas No</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Symptom 1: <?php echo $explanation['symptom1']['value']; ?></td>
                    <td><?php echo sprintf('%0.20f', $explanation['symptom1']['prob_yes']); ?></td>
                    <td><?php echo sprintf('%0.20f', $explanation['symptom1']['prob_no']); ?></td>
                </tr>
                <tr>
                    <td>Symptom 2: <?php echo $explanation['symptom2']['value']; ?></td>
                    <td><?php echo sprintf('%0.20f', $explanation['symptom2']['prob_yes']); ?></td>
                    <td><?php echo sprintf('%0.20f', $explanation['symptom2']['prob_no']); ?></td>
                </tr>
                <tr>
                    <td>Symptom 3: <?php echo $explanation['symptom3']['value']; ?></td>
                    <td><?php echo sprintf('%0.20f', $explanation['symptom3']['prob_yes']); ?></td>
                    <td><?php echo sprintf('%0.20f', $explanation['symptom3']['prob_no']); ?></td>
                </tr>
                <tr>
                    <td>Symptom 4: <?php echo $explanation['symptom4']['value']; ?></td>
                    <td><?php echo sprintf('%0.20f', $explanation['symptom4']['prob_yes']); ?></td>
                    <td><?php echo sprintf('%0.20f', $explanation['symptom4']['prob_no']); ?></td>
                </tr>
                <tr>
                    <td>Symptom 5: <?php echo $explanation['symptom5']['value']; ?></td>
                    <td><?php echo sprintf('%0.20f', $explanation['symptom5']['prob_yes']); ?></td>
                    <td><?php echo sprintf('%0.20f', $explanation['symptom5']['prob_no']); ?></td>
                </tr>
            </tbody>
        </table>

        <h3>Total Hasil Klasifikasi:</h3>
        <table class="table table-bordered table-custom">
            <thead>
                <tr>
                    <th>Probabilitas Yes</th>
                    <th>Probabilitas No</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo sprintf('%0.20f', $explanation['prob_yes']); ?></td>
                    <td><?php echo sprintf('%0.20f', $explanation['prob_no']); ?></td>
                </tr>
            </tbody>
        </table>
        
        <h3>Klasifikasi:</h3>
        <table class="table table-bordered table-custom">
            <thead>
                <tr>
                    <th>Klasifikasi Dangerous</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $explanation['classification']; ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Tambahkan grafik batang untuk visualisasi probabilitas -->
        <h4>Visualisasi Probabilitas:</h4>
        <canvas id="probabilityChart"></canvas>
        <script>
            var ctx = document.getElementById('probabilityChart').getContext('2d');
            var probabilityChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Dangerous Yes', 'Dangerous No'],
                    datasets: [{
                        label: 'Probabilitas',
                        data: [<?php echo $explanation['prob_yes']; ?>, <?php echo $explanation['prob_no']; ?>],
                        backgroundColor: ['#FF0000', '#007BFF'],
                        borderColor: ['#FF0000', '#007BFF'],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>
    <h3 style="margin-left:100px; padding-top: 80px;">Hasil Uji</h3>
<table class="table table-bordered table-custom" style="width: 800px; margin: auto;">
    <thead>
        <tr>
            <th>Precision</th>
            <th>Recall</th>
            <th>F1 Score</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $metrics['precision']; ?></td>
            <td><?php echo $metrics['recall']; ?></td>
            <td><?php echo $metrics['f1_score']; ?></td>
        </tr>
    </tbody>
</table>

</body>
</html>
