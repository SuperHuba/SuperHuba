<!DOCTYPE html>
<html>
<head>
	<title>Grafik</title>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<!-- Tambahkan Bootstrap CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "klasifikasi_hewan");

// Menghitung jumlah data dengan nilai "Dangerous" "Yes" dan "No"
$count_yes = mysqli_query($koneksi,"SELECT COUNT(*) AS Total_Dangerous_Yes FROM preprocesseddataset WHERE Dangerous = 'Yes';");
$result_yes = mysqli_fetch_assoc($count_yes);
$total_yes = $result_yes['Total_Dangerous_Yes'];

$count_no = mysqli_query($koneksi,"SELECT COUNT(*) AS Total_Dangerous_No FROM preprocesseddataset WHERE Dangerous = 'No';");
$result_no = mysqli_fetch_assoc($count_no);
$total_no = $result_no['Total_Dangerous_No'];
?>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<center>
				<h2>Jumlah Tingkat bahaya penyakit hewan dalam Dataset dengan Grafik Pie </h2>
			</center>
			<div>
			<canvas id="myChart" style="width: 500px; height: 500px;"></canvas>

			</div>
			<br/>
			<br/>
			<table class="table table-bordered">
			    <thead>
                <tr style="background-color: yellow;">
                    <th>No</th>
                    <th>Jumlah dengan Dangerous Yes</th>
                    <th>Jumlah dengan Dangerous No</th>
                </tr>

			    </thead>
			    <tbody>
			        <tr>
			            <td>1</td>
			            <td><?php echo $total_yes; ?></td>
			            <td><?php echo $total_no; ?></td>
			        </tr>
			    </tbody>
			</table>
		</div>
	</div>
</div>

<script>
	var ctx = document.getElementById("myChart").getContext('2d');
	var myChart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: ["Dangerous Yes", "Dangerous No"],
			datasets: [{
				label: '',
				data: [
				<?php 
				$count_yes = mysqli_query($koneksi,"SELECT COUNT(*) AS Total_Dangerous_Yes FROM preprocesseddataset WHERE Dangerous = 'Yes';");
				$result_yes = mysqli_fetch_assoc($count_yes);
				echo $result_yes['Total_Dangerous_Yes'];
				?>, 
				<?php 
				$count_no = mysqli_query($koneksi,"SELECT COUNT(*) AS Total_Dangerous_No FROM preprocesseddataset WHERE Dangerous = 'No';");
				$result_no = mysqli_fetch_assoc($count_no);
				echo $result_no['Total_Dangerous_No'];
				?>
				],
				backgroundColor: [
				'rgba(255, 99, 132, 0.8)', 
				'rgba(54, 162, 235, 0.2)'
				],
				borderColor: [
				'rgba(255, 99, 132, 1)',
				'rgba(54, 162, 235, 1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	});
</script>
</body>
</html>
