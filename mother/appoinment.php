<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../include/header.php");
include("../include/connection.php");

$motherid = (int)$_SESSION["mother_id"];

// Fetch appointments for the logged-in mother
$appointmentQuery = "SELECT * FROM appointments WHERE mother_id = '$motherid'";
$appointmentResult = mysqli_query($connect, $appointmentQuery);
if (!$appointmentResult) {
    die("Query failed: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyHealthMAMA</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .footer {
            background-color: pink;
            padding: 10px;
            color: white;
            text-align: center;
            position: fixed; /* Set position to fixed */
            bottom: 0; /* Position at the bottom */
            width: 100%; /* Full width */
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
            <div class="col-md-12">
                <h2 class="my-4">My Appointments</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Doctor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($appointmentResult)) {
                                $formattedTime = date("g:i A", strtotime($row['appointment_time']));
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>"; // Display appointment ID
                                echo "<td>" . $row['appointment_date'] . "</td>";
                                echo "<td>" . $formattedTime . "</td>";
                                echo "<td>" . $row['doctor_name'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



</body>
</html>
