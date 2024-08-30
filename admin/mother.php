<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Total Mothers</title>
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
    include("../include/connection.php");
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
                    $query = "SELECT firstname, surname, dob, phone, email, username, password FROM mothers";
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
