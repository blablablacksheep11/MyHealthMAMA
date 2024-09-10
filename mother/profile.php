<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include("../include/header.php");
include("../include/connection.php");

$mother = $_SESSION['mother'];


if (isset($_POST['change_uname'])) {
    $uname = $_POST['uname'];
    $query = "UPDATE mothers SET username='$uname' WHERE username='$mother'";
    $res = mysqli_query($connect, $query);
    $query = "UPDATE feedback SET sender_username='$uname' WHERE sender_username='$mother'";
    $res = mysqli_query($connect, $query);
    $query = "UPDATE videos SET mother_name='$uname' WHERE mother_name='$mother'";
    $res = mysqli_query($connect, $query);
    $_SESSION['mother'] = $uname;
    header("Location: ".$_SERVER['PHP_SELF']);
}
?>

<!DOCTYPE html>

<head>
    <title>PregnaCare +</title>
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
                    <?php
                    include("sidenav.php");

                    $query = "SELECT * FROM mothers WHERE username='$mother'";
                    $res = mysqli_query($connect, $query);
                    $row = mysqli_fetch_array($res);
                    ?>

                </div>
                <div class="col-md-10">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">

                                <h5>My Profile</h5>
                                <form>

                                    <table class="table table-bordered">
                                        <tr>
                                            <th colspan="2" class="text-center">My Details</th>
                                        </tr>

                                        <tr>
                                            <td>Firstname</td>
                                            <td><?php echo $row['firstname']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Username</td>
                                            <td><?php echo $row['surname']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Date of Birth</td>
                                            <td><?php echo $row['dob']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Phone number</td>
                                            <td><?php echo $row['phone']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Email Address</td>
                                            <td><?php echo $row['email']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td><?php echo $row['address']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Expected Due Date</td>
                                            <td><?php echo $row['due_date']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Obstetric_History</td>
                                            <td><?php echo $row['obstetric_history']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Medical Conditions</td>
                                            <td><?php echo $row['medical_conditions']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Username</td>
                                            <td><?php echo $row['username']; ?></td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-center my2">Change Username</h5>

                                <form action="../mother/profile.php" method="post">
                                    <label>Change Username</label>
                                    <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Enter Username">
                                    <br>
                                    <input type="submit" name="change_uname" class="btn btn-success" value="Change Username">
                                </form>
                                <br><br>
                                <?php

                                if (isset($_POST['change_pass'])) {

                                    $error = array();
                                    $old = $_POST['old_pass'];
                                    $new = $_POST['new_pass'];
                                    $con = $_POST['con_pass'];

                                    $ol = "SELECT * FROM mothers WHERE username='$mother'";
                                    $ols = mysqli_query($connect, $ol);
                                    $row = mysqli_fetch_array($ols);

                                    if (empty($old)) {
                                        $error['p'] = "Enter old password";
                                    }else if (empty($new)) {
                                        $error['p'] = "Enter new password";
                                    }else if (empty($con)) {
                                        $error['p'] = "Confirm password";
                                    }else if ($old != $row["password"]) {
                                        $error['p'] = "Invalid old password";
                                    }else if ($new != $con) {
                                        $error['p'] = "Both password does not match";
                                    }
                                    

                                    if (count($error)==0) {
                                        $query = "UPDATE mothers SET password='$new' WHERE username='$mother'";
                                        mysqli_query($connect,$query);
                                        echo "<script>alert('Password updated.')</script>";
                                    }
                                }
                                if (isset($error['p'])) {
                                    $e = $error['p'];

                                    $show = "<h5 class='text-center alert alert-danger'>$e</h5>";
                                }else{
                                    $show = "";
                                }
                                ?>

                                <h5 class="text-center my2">Change Password</h5>
                                <div>
                                            <?php 
                                            echo $show;
                                            ?>
                                        </div>

                                <form method="post">
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" name="old_pass" class="form-control" autocomplete="off" placeholder="Enter Old Password">
                                    </div>
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="new_pass" class="form-control" autocomplete="off" placeholder="Enter New Password">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="con_pass" class="form-control" autocomplete="off" placeholder="Enter Confirm Password">
                                    </div>
                                    <input type="submit" name="change_pass" class="btn btn-info" value="Change Password">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>