<?php
session_start();
error_reporting(0);
include("../include/connection.php");

if (isset($_POST['change_uname'])) {
    $uname = $_POST['uname'];

    if (empty($uname)) {

    }else {
        $doc = $_SESSION['doctor'];
        $getdoctorid = "SELECT id FROM doctors WHERE username='$doc'";
        $result = mysqli_query($connect, $getdoctorid);
        $doctorid = mysqli_fetch_column($result);
        $query = "UPDATE doctors SET username='$uname' WHERE id='$doctorid'";
        $res = mysqli_query($connect, $query); 
        $query = "UPDATE appointments SET doctor_name='$uname' WHERE doctor_name='$doc'";
        $res2 = mysqli_query($connect, $query);  
            $_SESSION['doctor'] = $uname;
            header("Location: ".$_SERVER['PHP_SELF']);
        
    }
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
                    <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                            
                            <?php
                            $doc = $_SESSION['doctor'];
                            $query = "SELECT * FROM doctors WHERE username='$doc'";
                            $res = mysqli_query($connect, $query);
                            $row = mysqli_fetch_array($res);
                            $doctorid = $row["id"];

                            ?>

                            <div class="my-3">
                                <table class="table table-bordered">
                                    <tr>
                                        <th colspan="2" class="text-center">Details</th>
                                    </tr>

                                    <tr>
                                        <td>Firstname</td>
                                        <td><?php echo $row['firstname']; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Surname</td>
                                        <td><?php echo $row['surname']; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Username</td>
                                        <td><?php echo $row['username']; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Email</td>
                                        <td><?php echo $row['email']; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Phone Number</td>
                                        <td><?php echo $row['phone']; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Gender</td>
                                        <td><?php echo $row['gender']; ?></td>
                                    </tr>
                                </table>
                            </div>

                            </div>
                            <div class="col-md-6">
                            <h5 class="text-center my2">Change Username</h5>
                            <form method="post">
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

                                    $ol = "SELECT * FROM doctors WHERE username='$doc'";
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
                                        $query = "UPDATE doctors SET password='$new' WHERE username='$doc'";
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