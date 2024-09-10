<?php
include("../include/connection.php");
session_start();

$appointmentid = $_SESSION["appointmentid"];
$newmotherusername = $_POST["motherusername"];
$newappointmentdate = $_POST["appointmentdate"];
$newappointmenttime = $_POST["appointmenttime"];
$newdoctorusername = $_POST["doctorusername"];

// update appointment data into database if input is not empty
$getmotherid = "SELECT id FROM mothers WHERE username='$newmotherusername'";
$result = mysqli_query($connect, $getmotherid);
$motherid = mysqli_fetch_column($result);
$insertQuery = "UPDATE appointments SET mother_id='$motherid', appointment_date='$newappointmentdate', appointment_time='$newappointmenttime', doctor_name='$newdoctorusername' WHERE id='$appointmentid'";
if (mysqli_query($connect, $insertQuery)) {
} else {
    echo "Error: " . $insertQuery . "<br>" . mysqli_error($connect);
}
?>