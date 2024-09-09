<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../include/header.php");
include("../include/connection.php");

// Fetch list of mothers' usernames from the database
$motherQuery = "SELECT username FROM mothers";
$motherResult = mysqli_query($connect, $motherQuery);
if (!$motherResult) {
    die("Query failed: " . mysqli_error($connect));
}
$motherUsernames = array();
while ($row = mysqli_fetch_assoc($motherResult)) {
    $motherUsernames[] = $row['username'];
}

// Initialize $weightData array

// Fetch weight data from the database for the selected mother
if (isset($_POST['selectMother'])) {
    
    $selectedMother = $_POST['selectedMother'];
    
    
    // Retrieve weight data based on mother_name (which is the same as username)
    $getmotherid = "SELECT id FROM mothers WHERE username = '$selectedMother'";
    $result = mysqli_query($connect, $getmotherid);
    $motherid = (int)mysqli_fetch_column($result);
    $weightQuery = "SELECT * FROM weight_measurements WHERE mother_id = '$motherid' ORDER BY date";
    $result2 = mysqli_query($connect, $weightQuery);
    if (!$result) {
        die("Query failed: " . mysqli_error($connect));
    }
    while ($row = mysqli_fetch_assoc($result2)) {
        // Convert date format for HTML input
        $row['date'] = date('Y-m-d', strtotime($row['date']));
        $weightData[] = $row;
    }

}

// Process form submission
if(isset($_POST['inputDate']) && isset($_POST['inputWeight']) && isset($_POST['motherUsername'])) {
    $inputDate = $_POST['inputDate'];
    $inputWeight = $_POST['inputWeight'];
    $motherUsername = $_POST['motherUsername'];
    $getmotherid = "SELECT id FROM mothers WHERE username = '$motherUsername'";
    $result = mysqli_query($connect, $getmotherid);
    $motherid = (int)mysqli_fetch_column($result);

    // Insert data into the database
    $insertQuery = "INSERT INTO weight_measurements (mother_id, date, weight) VALUES ('$motherid', '$inputDate', '$inputWeight')";
    $insertResult = mysqli_query($connect, $insertQuery);
    if($insertResult) {
        // Data inserted successfully
        // Redirect to prevent form resubmission
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        // Error occurred during insertion
        echo "Error: " . mysqli_error($connect);
    }
}

//handdle record deletion
if(isset($_POST["removeRecord"])){
        $recordid = $_POST["removeRecord"];
        $deleteQuery = "DELETE FROM weight_measurements WHERE id = '$recordid'";
        mysqli_query($connect, $deleteQuery);
        header("Location: ".$_SERVER['PHP_SELF']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weight Tracking</title>
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
            height: 100%;
        }

        .row {
            height: 100%;
        }

        
    </style>
</head>
<body style="background-image: url(img/background1.jpg);background-repeat:no-repeat; background-size:cover;">
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
                                <h2 class="my-4">Weight Tracking</h2>
                                <!-- Form to select mother -->
                                <form method="post">
                                    <div class="form-group">
                                        <label for="selectedMother">Select Mother</label>
                                        <select class="form-control" name="selectedMother" id="selectedMother" required>
                                            
                                            <?php
                                            // Populate select dropdown with mothers' usernames
                                            foreach ($motherUsernames as $username) {
                                                if(isset($selectedMother) && $selectedMother == $username){
                                                    echo "<option value='$username' selected>$username</option>";
                                                }else{
                                                echo "<option value='$username'>$username</option>";}
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="selectMother">Select</button>
                                </form>
                                <hr>
                                <form method="post">
                                    <?php if (!empty($weightData) || isset($selectedMother)): ?>
                                        <input type="hidden" name="motherUsername" value="<?php echo $selectedMother; ?>">
                                        <div class="form-group">
                                            <label for="inputDate">Date</label>
                                            <input type="date" class="form-control" id="inputDate" name="inputDate" value="<?php echo isset($inputDate) ? $inputDate : ''; ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputWeight">Weight (kg)</label>
                                            <input type="number" class="form-control" id="inputWeight" name="inputWeight" step="0.01" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    <?php endif; ?>
                                </form>
                                <!-- Display weight chart -->
                                <?php if (!empty($weightData)): ?>
                                    <div class="my-4">
                                        <canvas id="weightChart"></canvas>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <!-- Display weight data in table -->
                                <?php if (!empty($weightData)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Weight (kg)</th>
                                                    <th>Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($weightData as $data): ?>
                                                    <tr>
                                                        <td><?php echo $data['date']; ?></td>
                                                        <td><?php echo $data['weight']; ?></td>
                                                        <td>
                                                            <form action="../doctor/maternal_health.php" method="post">
                                                                <button type="submit" class="btn btn-danger btn-sm" name="removeRecord" value="<?php echo $data['id']; ?>">Remove</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to update chart -->
    <?php if (!empty($weightData)){ ?>
        <script>
            // Initialize the weight chart
            var ctx = document.getElementById('weightChart').getContext('2d');
            var weightChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode(array_column($weightData, 'date')); ?>,
                    datasets: [{
                        label: 'Weight (kg)',
                        data: <?php echo json_encode(array_column($weightData, 'weight')); ?>,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: false, // Start from 0 or not
                                suggestedMin: 60, // Minimum value
                                suggestedMax: 150 // Maximum value
                            }
                        }]
                    }
                }
            });
        </script>
    <?php } ?>

</body>
</html>
