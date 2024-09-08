<?php
include("../include/connection.php");

    $motherusername = $_POST['motherusername'];
    $appointmentdate = $_POST['appointmentdate'];
    $appointmenttime = $_POST['appointmenttime'];
    $doctorusername = $_POST['doctorusername'];

    // Insert appointment data into database if input is not empty
        $getmotherid = "SELECT id FROM mothers WHERE username='$motherusername'";
        $result = mysqli_query($connect, $getmotherid);
        $motherid = mysqli_fetch_column($result);
        $insertQuery = "INSERT INTO appointments (mother_id, appointment_date, appointment_time, doctor_name) VALUES ('$motherid', '$appointmentdate', '$appointmenttime', '$doctorusername')";
        if (mysqli_query($connect, $insertQuery)) {
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($connect);
        }

?>
