<?php
include("../include/connection.php");
session_start();

if(isset($_POST["editbutton"])){
    $selectedmotherid = $_POST["editbutton"];
    $getmotherinfo = "SELECT * FROM mothers WHERE id='$selectedmotherid'";
    $result = mysqli_query($connect, $getmotherinfo);
    $motherinfo = mysqli_fetch_assoc($result);

    //store data into session
    $_SESSION["id"] = $selectedmotherid;
    $_SESSION["firstname"] = $motherinfo["firstname"];
    $_SESSION["surname"] = $motherinfo["surname"];
    $_SESSION["dob"] = $motherinfo["dob"];
    $_SESSION["phone"] = $motherinfo["phone"];
    $_SESSION["email"] = $motherinfo["email"];
    $_SESSION["username"] = $motherinfo["username"];
    $_SESSION["password"] = $motherinfo["password"];

    header("Location: edit-mother-info.php");
}

if(isset($_POST["removebtn"])){
    $selectedmotherid = $_POST["removebtn"];
    $deletemotherinfo = "DELETE appointments.*,feedback.*,mothers.*,videos.*,weight_measurements.* FROM mothers INNER JOIN appointments ON mothers.id=appointments.mother_id INNER JOIN feedback ON mothers.username=feedback.sender_username INNER JOIN videos ON mothers.id=videos.mother_id INNER JOIN weight_measurements ON mothers.id=weight_measurements.mother_id WHERE mothers.id='$selectedmotherid'";
    mysqli_query($connect, $deletemotherinfo);

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>MyHealthMAMA</title>
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

    <?php
    include("../include/header.php");
    ?>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php
                    include("sidenav.php");
                    ?>
                </div>
                <div class="col-md-10">
                    <h5 class="text-center">Total Mothers</h5>

                    <?php 
                    // Fetch mother information
                    $query = "SELECT id, firstname, surname, dob, phone, email, username, password FROM mothers";
                    $res = mysqli_query($connect, $query);

                    // Initialize output variable
                    $output = "";

                    $output .= "
                        <table class='table table-bordered'>
                            <tr>
                                <th>First Name</th>
                                <th>Surname</th>
                                <th>Date of Birth</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Actions</th>
                            </tr>
                    ";

                    // Check if there are no records
                    if (mysqli_num_rows($res) < 1) {
                        $output .= "
                            <tr>
                                <td colspan='7' class='text-center'>No mother records found.</td>
                            </tr>
                        ";
                    }

                    // Fetch and display mother records
                    while ($row = mysqli_fetch_assoc($res)) {
                        $output .= "
                            <tr>
                                <td>".$row['firstname']."</td>
                                <td>".$row['surname']."</td>
                                <td>".$row['dob']."</td>
                                <td>".$row['phone']."</td>
                                <td>".$row['email']."</td>
                                <td>".$row['username']."</td>
                                <td>".$row['password']."</td>
                                <td>
        <form method='post'><button type='submit' class='btn btn-primary' name='editbutton' value=".$row['id'].">Edit</button>
        <button id='removebtn' name='removebtn' class='btn btn-primary' style='background-color: red; border: none;' value=".$row['id'].">Remove</button>
        </form></td>
                            </tr>
                        ";
                    }

                    $output .= "</table>";
                    echo $output;
                    ?>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
