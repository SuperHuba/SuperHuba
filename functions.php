<?php
// functions.php

function getTrainingData($conn) {
    $sql = "SELECT AnimalName, Symptom1, Symptom2, Symptom3, Symptom4, Symptom5, Dangerous FROM preprocesseddataset";
    $result = $conn->query($sql);
    $data = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

function calculatePriorProbabilities($data) {
    $total = count($data);
    $countYes = 0;
    $countNo = 0;

    foreach ($data as $row) {
        if ($row['Dangerous'] == 'yes') {
            $countYes++;
        } else {
            $countNo++;
        }
    }

    return [
        'yes' => $countYes / $total,
        'no' => $countNo / $total,
    ];
}

function calculateLikelihood($data) {
    $symptomCount = ['yes' => [], 'no' => []];
    $totalYes = 0;
    $totalNo = 0;

    foreach ($data as $row) {
        if ($row['Dangerous'] == 'yes') {
            $totalYes++;
            for ($i = 1; $i <= 5; $i++) {
                $symptom = $row["Symptom$i"];
                if (!isset($symptomCount['yes'][$symptom])) {
                    $symptomCount['yes'][$symptom] = 0;
                }
                $symptomCount['yes'][$symptom]++;
            }
        } else {
            $totalNo++;
            for ($i = 1; $i <= 5; $i++) {
                $symptom = $row["Symptom$i"];
                if (!isset($symptomCount['no'][$symptom])) {
                    $symptomCount['no'][$symptom] = 0;
                }
                $symptomCount['no'][$symptom]++;
            }
        }
    }

    $likelihood = ['yes' => [], 'no' => []];
    foreach ($symptomCount['yes'] as $symptom => $count) {
        $likelihood['yes'][$symptom] = $count / $totalYes;
    }
    foreach ($symptomCount['no'] as $symptom => $count) {
        $likelihood['no'][$symptom] = $count / $totalNo;
    }

    return $likelihood;
}

function calculatePosterior($prior, $likelihood, $symptoms) {
    $posteriorYes = $prior['yes'];
    $posteriorNo = $prior['no'];

    foreach ($symptoms as $symptom) {
        if (isset($likelihood['yes'][$symptom])) {
            $posteriorYes *= $likelihood['yes'][$symptom];
        } else {
            $posteriorYes *= 1e-6;
        }

        if (isset($likelihood['no'][$symptom])) {
            $posteriorNo *= $likelihood['no'][$symptom];
        } else {
            $posteriorNo *= 1e-6;
        }
    }

    return [
        'yes' => $posteriorYes,
        'no' => $posteriorNo,
    ];
}
?>
