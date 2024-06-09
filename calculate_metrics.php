<?php
// Fungsi untuk menghitung Precision, Recall, dan F1 Score
function calculateMetrics($true_labels, $predicted_labels) {
    $tp = 0; // True Positives
    $fp = 0; // False Positives
    $tn = 0; // True Negatives
    $fn = 0; // False Negatives

    for ($i = 0; $i < count($true_labels); $i++) {
        if ($true_labels[$i] == 'yes' && $predicted_labels[$i] == 'yes') {
            $tp++;
        } elseif ($true_labels[$i] == 'no' && $predicted_labels[$i] == 'yes') {
            $fp++;
        } elseif ($true_labels[$i] == 'no' && $predicted_labels[$i] == 'no') {
            $tn++;
        } elseif ($true_labels[$i] == 'yes' && $predicted_labels[$i] == 'no') {
            $fn++;
        }
    }

    $precision = $tp / ($tp + $fp);
    $recall = $tp / ($tp + $fn);
    $f1_score = 2 * ($precision * $recall) / ($precision + $recall);

    return [
        'precision' => $precision,
        'recall' => $recall,
        'f1_score' => $f1_score
    ];
}
?>
