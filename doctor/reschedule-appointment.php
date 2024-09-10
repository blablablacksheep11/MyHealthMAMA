<?php
include("../include/connection.php");
session_start();

if (isset($_POST['rescheduleAppointment'])) {
    $appointmentId = $_POST['rescheduleAppointment'];
    $rescheduleQuery = "SELECT * FROM appointments WHERE id = '$appointmentId'";
    if ($result = mysqli_query($connect, $rescheduleQuery)) {
        $valuereturned = mysqli_fetch_assoc($result);
        $motherid = $valuereturned["mother_id"];
        //get mother username
        $getmotherusername = "SELECT username FROM mothers WHERE id='$motherid'";
        $result = mysqli_query($connect, $getmotherusername);
        $motherusername = mysqli_fetch_column($result);

        $_SESSION["appointmentid"] = $appointmentId;
        $_SESSION["motherusername"] = $motherusername;
        $_SESSION["appointmentdate"] = $valuereturned["appointment_date"];
        $_SESSION["appointmenttime"] = $valuereturned["appointment_time"];
        $_SESSION["doctorname"] = $valuereturned["doctor_name"];
    } else {
        echo "Error: " . $rescheduleQuery . "<br>" . mysqli_error($connect);
    }
} else {
    $motherusername = $_SESSION["motherusername"];
    $appointmentdate = $_SESSION["appointmentdate"];
    $appointmenttime = $_SESSION["appointmenttime"];
    $doctorusername = $_SESSION["doctorname"];
    $formattedappointmenttime = date("H:i", strtotime($appointmenttime)); 

    //get the mother name in list
    $motherQuery = "SELECT username FROM mothers";
    $motherResult = mysqli_query($connect, $motherQuery);
    if (!$motherResult) {
        die("Query failed: " . mysqli_error($connect));
    }
    $motherUsernames = array();
    while ($row = mysqli_fetch_assoc($motherResult)) {
        $motherUsernames[] = $row['username'];
    }
    echo "<div class='form-group'>";
    echo "<label for='motherUsername'>Select Mother</label>";
    echo "<select class='form-control' name='motherUsername' id='motherUsername' required>";
    foreach ($motherUsernames as $username) {
        if ($username == $motherusername) {
            echo "<option value='$username' selected>$username</option>";
        } else {
            echo "<option value='$username'>$username</option>";
        }
    }

    echo "</select>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='appointmentDate'>Appointment Date</label>";
    echo "<input type='date' class='form-control' id='appointmentDate' name='appointmentDate' value='$appointmentdate' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='appointmentTime'>Appointment Time</label>";
    echo "<input type='time' class='form-control' id='appointmentTime' name='appointmentTime' value='$formattedappointmenttime' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='doctorUsername'>Select Doctor</label>";
    echo "<select class='form-control' name='doctorUsername' id='doctorUsername' required>";

    //get the doctor name in list
    $doctorQuery = "SELECT username FROM doctors";
    $doctorResult = mysqli_query($connect, $doctorQuery);
    if (!$doctorResult) {
        die("Query failed: " . mysqli_error($connect));
    }
    $doctorUsernames = array();
    while ($row = mysqli_fetch_assoc($doctorResult)) {
        $doctorUsernames[] = $row['username'];
    }

    foreach ($doctorUsernames as $username) {
        if ($username == $doctorusername) {
            echo "<option value='$username' selected>$username</option>";
        } else {
            echo "<option value='$username'>$username</option>";
        }
    }

    echo "</select>";
    echo "</div>";
    echo "<button type='submit' class='btn btn-primary' id='reschedulebutton'>Reschedule Appointment</button>";
    echo "<button type='submit' class='btn btn-primary' id='cancelbutton' style='margin-left: 2%'>Cancel</button>";
}
