<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PregnaCare +</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: auto;
        }

        .container-fluid {
            height: fit-content;
            overflow: auto;
        }

        .row {
            height: 100%;
        }
        
        .footer {
            background-color: pink;
            padding: 10px;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body style="background-image: url(img/background1.jpg);background-repeat:no-repeat; background-size:cover;">
<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


include("../include/header.php");
include("../include/connection.php");
$motherid = (int)$_SESSION['mother_id'];


// Fetch weight data for the current mother
$weightQuery = "SELECT * FROM weight_measurements WHERE mother_id = '$motherid' ORDER BY date";
$result = mysqli_query($connect, $weightQuery);
if (!$result) {
    die("Query failed: " . mysqli_error($connect));
}
$weightData = array();
while ($row = mysqli_fetch_assoc($result)) {
    // Convert date format for HTML input
    $row['date'] = date('Y-m-d', strtotime($row['date']));
    $weightData[] = $row;
}   
?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
        <div class="col-md-2" style="margin-left: -30px;">
                <?php include("sidenav.php"); ?>
            </div>
            <div class="col-md-10">
            <div class="container-fluid">
                    <div class="row">
                    <div class="col-md-6">
                <h2 class="my-4">Your Weight Tracking</h2>
                <!-- Display weight chart -->
                <div class="my-4">
                    <canvas id="weightChart"></canvas>
                </div>
            </div>
            <div class="col-md-12">
                <!-- Display weight data in table -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Weight (kg)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($weightData as $data): ?>
                            <tr>
                                <td><?php echo $data['date']; ?></td>
                                <td><?php echo $data['weight']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<!-- JavaScript to update chart -->
<script>
    // Initialize arrays to store date and weight data
    var dateData = <?php echo isset($weightData) ? json_encode(array_column($weightData, 'date')) : '[]'; ?>;
    var weightData = <?php echo isset($weightData) ? json_encode(array_column($weightData, 'weight')) : '[]'; ?>;

    // Initialize the weight chart
    var ctx = document.getElementById('weightChart').getContext('2d');
    var weightChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dateData,
            datasets: [{
                label: 'Weight (kg)',
                data: weightData,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    // Function to update chart data
    function updateWeightChart() {
        // Update chart data with the stored arrays
        weightChart.data.labels = dateData;
        weightChart.data.datasets[0].data = weightData;
        weightChart.update();
    }

    // Call the function to update the chart
    updateWeightChart();
</script>

<div class="footer">
        <p>Copyright by TAN YIT JIE. All Rights Reserved.</p>
    </div>

</body>
</html>