<?php
// Proses klasifikasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config.php';
    include 'functions.php';
    include 'calculate_metrics.php'; // Menambahkan file untuk menghitung metrik evaluasi

    $animal = $_POST['animal'];
    $symptom1 = $_POST['symptom1'];
    $symptom2 = $_POST['symptom2'];
    $symptom3 = $_POST['symptom3'];
    $symptom4 = $_POST['symptom4'];
    $symptom5 = $_POST['symptom5'];

    $symptoms = [$symptom1, $symptom2, $symptom3, $symptom4, $symptom5];
    

    $data = getTrainingData($conn);
    $conn->close();

    $prior = calculatePriorProbabilities($data);
    $likelihood = calculateLikelihood($data);
    $posterior = calculatePosterior($prior, $likelihood, $symptoms);

    // Menentukan klasifikasi
    $classification = ($posterior['yes'] > $posterior['no']) ? 'yes' : 'no';

    // Simpan penjelasan hasil ke dalam variabel
    $explanation = [
        'symptom1' => [
            'value' => $symptom1,
            'prob_yes' => isset($likelihood['yes'][$symptom1]) ? $likelihood['yes'][$symptom1] : 0,
            'prob_no' => isset($likelihood['no'][$symptom1]) ? $likelihood['no'][$symptom1] : 0
        ],
        'symptom2' => [
            'value' => $symptom2,
            'prob_yes' => isset($likelihood['yes'][$symptom2]) ? $likelihood['yes'][$symptom2] : 0,
            'prob_no' => isset($likelihood['no'][$symptom2]) ? $likelihood['no'][$symptom2] : 0
        ],
        'symptom3' => [
            'value' => $symptom3,
            'prob_yes' => isset($likelihood['yes'][$symptom3]) ? $likelihood['yes'][$symptom3] : 0,
            'prob_no' => isset($likelihood['no'][$symptom3]) ? $likelihood['no'][$symptom3] : 0
        ],
        'symptom4' => [
            'value' => $symptom4,
            'prob_yes' => isset($likelihood['yes'][$symptom4]) ? $likelihood['yes'][$symptom4] : 0,
            'prob_no' => isset($likelihood['no'][$symptom4]) ? $likelihood['no'][$symptom4] : 0
        ],
        'symptom5' => [
            'value' => $symptom5,
            'prob_yes' => isset($likelihood['yes'][$symptom5]) ? $likelihood['yes'][$symptom5] : 0,
            'prob_no' => isset($likelihood['no'][$symptom5]) ? $likelihood['no'][$symptom5] : 0
        ],
        'prob_yes' => $posterior['yes'],
        'prob_no' => $posterior['no'],
        'classification' => $classification
    ];

    // Simpan hasil klasifikasi ke sesi
    session_start();
    $_SESSION['explanation'] = $explanation;

    // Uji hasil klasifikasi
    $true_labels = ['yes', 'no', 'yes', 'no', 'yes']; // Label sebenarnya (diganti dengan data yang sesuai)
    $predicted_labels = [$classification, 'no', 'yes', 'no', 'yes']; // Prediksi model (diganti dengan data yang sesuai)
    $metrics = calculateMetrics($true_labels, $predicted_labels);

    // Simpan metrik evaluasi ke dalam sesi
    $_SESSION['metrics'] = $metrics;

    // Alihkan ke halaman hasil.php
    header("Location: hasil.php");
    exit();
}
?>
