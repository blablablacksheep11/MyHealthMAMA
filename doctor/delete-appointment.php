<?php
include("../include/connection.php");

    $appointmentId = $_POST['appointmentId'];

    // delete appointment data from database
        $deleteQuery = "DELETE FROM appointments WHERE id='$appointmentId'";
        if (mysqli_query($connect, $deleteQuery)) {
        } else {
            echo "Error: " . $deleteQuery . "<br>" . mysqli_error($connect);
        }

?>
