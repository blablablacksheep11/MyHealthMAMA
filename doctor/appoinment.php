<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../include/header.php");
include("../include/connection.php");

// Check if form is submitted
if (isset($_POST["addbutton"])) {
    // Get input data if set
    $motherUsername = isset($_POST['motherUsername']) ? $_POST['motherUsername'] : '';
    $appointmentDate = isset($_POST['appointmentDate']) ? $_POST['appointmentDate'] : '';
    $appointmentTime = isset($_POST['appointmentTime']) ? $_POST['appointmentTime'] : '';
    $doctorUsername = isset($_POST['doctorUsername']) ? $_POST['doctorUsername'] : '';

    // Insert appointment data into database if input is not empty
    if (!empty($motherUsername) && !empty($appointmentDate) && !empty($appointmentTime) && !empty($doctorUsername)) {
        $getmotherid = "SELECT id FROM mothers WHERE username='$motherUsername'";
        $result = mysqli_query($connect, $getmotherid);
        $motherid = mysqli_fetch_column($result);
        $insertQuery = "INSERT INTO appointments (mother_id, appointment_date, appointment_time, doctor_name) VALUES ('$motherid', '$appointmentDate', '$appointmentTime', '$doctorUsername')";
        if (mysqli_query($connect, $insertQuery)) {
            echo "<script>alert('New appointment created successfully');</script>";
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($connect);
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
    <title>PregnaCare +</title>
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
<body style="background-image: url(img/background3.jpg);background-repeat:no-repeat; background-size:cover;">

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
                            <h2 class="my-4" style="color: #1434A4;">Appointment Management</h2>
                            <form id="appointmentform" method="post">
                                <div class="form-group">
                                    <label for="motherUsername">Select Mother</label>
                                    <select class="form-control" name="motherUsername" id="motherUsername" required>
                                        <option selected disabled>Select a mother</option>
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
                                <button type="submit" class="btn btn-primary" id="addbutton">Create Appointment</button>
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
                                        <th colspan="2">Actions</th>
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
                                        $currentmotherid = $row['mother_id'];
                                        $getmothername = "SELECT username FROM mothers WHERE id='$currentmotherid'";
                                        $result = mysqli_query($connect, $getmothername);
                                        $mothername = mysqli_fetch_column($result);
                                        echo "<td>" . $mothername . "</td>";
                                        echo "<td>" . $row['appointment_date'] . "</td>";
                                        echo "<td>" . $formattedTime . "</td>";
                                        echo "<td>" . $row['doctor_name'] . "</td>";
                                        echo "<td style='border-right:none'><button class='btn btn-primary reschedule-appointment' id='reschedule-appointment' value='".$row['id']."'>Reschedule</button></td>"; // Pass appointment ID as data attribute
                                        echo "<td style='border-left:none'><button class='btn btn-danger delete-appointment' id='delete-appointment' value='".$row['id']."'>Delete</button></td>"; // Pass appointment ID as data attribute
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

<!-- jQuery for functionality -->
<script>
    $(document).ready(function() {
        // Add event listener to dynamically added reschedule buttons
        $(document).on("click", "#reschedule-appointment", function(e) {
            e.preventDefault();
            // Retrieve the appointment ID associated with the button
            var appointmentId = $(this).val();
            // Ask for confirmation before reschedule
            if (confirm("Are you sure you want to reschedule this record?")) {
                // Send AJAX request to reschedule appointment
                $.ajax({
                    url: "reschedule-appointment.php",
                    method: "POST",
                    data: { rescheduleAppointment: appointmentId }, // Pass the appointment ID to reschedule
                    success: function(response) {
                        $("#appointmentform").load("reschedule-appointment.php");
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            }
        });
        

        //ajax for add new appointment
        $(document).on("click", "#addbutton", function(e) {
            e.preventDefault();
            
            var motherusername = $("#motherUsername").val();
            var appointmentdate = $("#appointmentDate").val();
            var appointmenttime = $("#appointmentTime").val();
            var doctorusername = $("#doctorUsername").val();
                // Send AJAX request to add appointment
                if(appointmenttime.length>0 && appointmentdate.length>0){
                $.ajax({
                    url: "add-appointment.php",
                    method: "POST",
                    data: {
                        motherusername: motherusername,
                        appointmentdate: appointmentdate,
                        appointmenttime: appointmenttime,
                        doctorusername: doctorusername
                    }, 
                    success: function(response) {
                        location.reload();
                        alert("Record added");
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            }else{
                alert("Please provide the correct information");
            }
        });

        //ajax for delete appointment
        $(document).on("click", "#delete-appointment", function(e) {
            e.preventDefault();
            // Retrieve the appointment ID associated with the button
            var appointmentId = $(this).val();
            // Ask for confirmation before reschedule
            if (confirm("Are you sure you want to delete this record?")) {
                // Send AJAX request to reschedule appointment
                $.ajax({
                    url: "delete-appointment.php",
                    method: "POST",
                    data: { appointmentId: appointmentId }, // Pass the appointment ID to reschedule
                    success: function(response) {
                        location.reload();
                        alert('Appointment deleted.');
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        //ajax for update appointment
        $(document).on("click", "#reschedulebutton", function(e) {
            e.preventDefault();
            
            var motherusername = $("#motherUsername").val();
            var appointmentdate = $("#appointmentDate").val();
            var appointmenttime = $("#appointmentTime").val();
            var doctorusername = $("#doctorUsername").val();
                // Send AJAX request to add appointment
                if(appointmenttime.length>0 && appointmentdate.length>0){
                $.ajax({
                    url: "update-appointment.php",
                    method: "POST",
                    data: {
                        motherusername: motherusername,
                        appointmentdate: appointmentdate,
                        appointmenttime: appointmenttime,
                        doctorusername: doctorusername
                    }, 
                    success: function(response) {
                        location.reload();
                        alert("Appointment rescheduled");
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            }else{
                alert("Please provide the correct information");
            }
        });
    });
</script>


    
</body>
</html>
