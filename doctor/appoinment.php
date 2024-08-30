<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../include/header.php");
include("../include/connection.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input data if set
    $motherUsername = isset($_POST['motherUsername']) ? $_POST['motherUsername'] : '';
    $appointmentDate = isset($_POST['appointmentDate']) ? $_POST['appointmentDate'] : '';
    $appointmentTime = isset($_POST['appointmentTime']) ? $_POST['appointmentTime'] : '';
    $doctorUsername = isset($_POST['doctorUsername']) ? $_POST['doctorUsername'] : '';

    // Insert appointment data into database if input is not empty
    if (!empty($motherUsername) && !empty($appointmentDate) && !empty($appointmentTime) && !empty($doctorUsername)) {
        $insertQuery = "INSERT INTO appointments (mother_name, appointment_date, appointment_time, doctor_name) VALUES ('$motherUsername', '$appointmentDate', '$appointmentTime', '$doctorUsername')";
        if (mysqli_query($connect, $insertQuery)) {
            echo "<script>alert('New appointment created successfully');</script>";
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($connect);
        }
    }

    // Handle appointment deletion
    if (isset($_POST['deleteAppointment'])) {
        $appointmentId = $_POST['deleteAppointment'];
        $deleteQuery = "DELETE FROM appointments WHERE id = '$appointmentId'";
        if (mysqli_query($connect, $deleteQuery)) {
            echo "<script>alert('Appointment deleted successfully');</script>";
        } else {
            echo "Error: " . $deleteQuery . "<br>" . mysqli_error($connect);
        }
    }
}

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

// Fetch list of doctors' usernames from the database
$doctorQuery = "SELECT username FROM doctors";
$doctorResult = mysqli_query($connect, $doctorQuery);
if (!$doctorResult) {
    die("Query failed: " . mysqli_error($connect));
}
$doctorUsernames = array();
while ($row = mysqli_fetch_assoc($doctorResult)) {
    $doctorUsernames[] = $row['username'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .footer {
            background-color: pink;
            padding: 10px;
            color: white;
            text-align: center;
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
                            <h2 class="my-4">Appointment Management</h2>
                            <form method="post">
                                <div class="form-group">
                                    <label for="motherUsername">Select Mother</label>
                                    <select class="form-control" name="motherUsername" id="motherUsername" required>
                                        <?php
                                        foreach ($motherUsernames as $username) {
                                            echo "<option value='$username'>$username</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="appointmentDate">Appointment Date</label>
                                    <input type="date" class="form-control" id="appointmentDate" name="appointmentDate" required>
                                </div>
                                <div class="form-group">
                                    <label for="appointmentTime">Appointment Time</label>
                                    <input type="time" class="form-control" id="appointmentTime" name="appointmentTime" required>
                                </div>
                                <div class="form-group">
                                    <label for="doctorUsername">Select Doctor</label>
                                    <select class="form-control" name="doctorUsername" id="doctorUsername" required>
                                        <?php
                                        foreach ($doctorUsernames as $username) {
                                            echo "<option value='$username'>$username</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Create Appointment</button>
                            </form>
                        </div>
                        <!-- Display appointment data in table -->
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mother Username</th>
                                        <th>Appointment Date</th>
                                        <th>Appointment Time</th>
                                        <th>Doctor Username</th>
                                        <th>Remove</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // Fetch appointment data from the database
                                    $appointmentQuery = "SELECT * FROM appointments";
                                    $appointmentResult = mysqli_query($connect, $appointmentQuery);
                                    if (!$appointmentResult) {
                                        die("Query failed: " . mysqli_error($connect));
                                    }
                                    while ($row = mysqli_fetch_assoc($appointmentResult)) {
                                        $formattedTime = date("g:i A", strtotime($row['appointment_time']));
                                        echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>"; // Display appointment ID
                                        echo "<td>" . $row['mother_name'] . "</td>";
                                        echo "<td>" . $row['appointment_date'] . "</td>";
                                        echo "<td>" . $formattedTime . "</td>";
                                        echo "<td>" . $row['doctor_name'] . "</td>";
                                        echo "<td><button class='btn btn-danger btn-sm remove-appointment' data-appointment-id='".$row['id']."'>Remove</button></td>"; // Pass appointment ID as data attribute
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
        </div>
    </div>
</div>

<!-- jQuery for removal functionality -->
<script>
    $(document).ready(function() {
        // Add event listener to dynamically added remove buttons
        $(document).on("click", ".remove-appointment", function() {
            // Retrieve the appointment ID associated with the button
            var appointmentId = $(this).data("appointment-id");
            // Ask for confirmation before deletion
            if (confirm("Are you sure you want to remove this record?")) {
                // Send AJAX request to delete appointment
                $.ajax({
                    url: "appoinment.php", // Use the same file for handling deletion
                    method: "POST",
                    data: { deleteAppointment: appointmentId }, // Pass the appointment ID to delete
                    success: function(response) {
                        // Reload the page after successful deletion
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>


    
</body>
</html>
