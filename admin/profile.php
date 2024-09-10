<?php
include("../include/connection.php");
session_start();

if (isset($_POST['change'])){
    $uname = $_POST['uname'];
    
    if (empty($uname)) {
    }else{
        $ad = $_SESSION['admin'];
        $getadminid = "SELECT id FROM admin WHERE username='$ad'";
        $result = mysqli_query($connect, $getadminid);
        $adminid = mysqli_fetch_column($result);
        $query = "UPDATE admin SET username='$uname' WHERE id='$adminid'";
        $res = mysqli_query($connect,$query);
        $_SESSION['admin'] = $uname;
        header("Location:".$_SERVER['PHP_SELF']);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PregnaCare +</title>
    <style>
        .profile-pic-container {
            width: 250px;
            height: 250px;
            border-radius: 50%; /* Make it circular */
            overflow: hidden; /* Hide any overflow */
            background-color: #ccc; /* Fallback color */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-pic-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover; /* Ensure the image fills the container */
        }

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

$ad = $_SESSION['admin'];
$query = "SELECT * from admin WHERE username='$ad'";
$res= mysqli_query($connect,$query);

while ($row =mysqli_fetch_array($res)){
    $username = $row['username'];
    $profiles = $row['profile'];
}
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
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4><?php echo $username; ?> Profile</h4>
                            <?php 
                            if (isset($_POST['update'])){
                                $profile = $_FILES['profile'];
                                if (empty($profile)) {
                                }else{
                                    $profileName = $_FILES['profile']['name'];
                                    $query = "UPDATE admin SET profile = '$profileName' WHERE username='$ad'";
                                    $result = mysqli_query($connect,$query);
                                    if ($result) {
                                        move_uploaded_file($_FILES['profile']['tmp_name'],"img/$profileName");
                                        header("Location:".$_SERVER["PHP_SELF"]);
                                    }
                                }
                            }
                            ?>
                            <form method="post" enctype="multipart/form-data">
                                <div class="profile-pic-container">
                                    <?php 
                                    echo "<img src='img/$profiles' alt='Profile Picture'>";
                                    ?>
                                </div>
                                <br><br>
                                <div class="form-group">
                                    <label>Update Profile</label>
                                    <input type="file" name="profile" class="form-control">
                                </div>
                                <br>
                                <input type="submit" name="update" value="UPDATE" class="btn btn-success">
                            </form>
                        </div>
                        <div class="col-md-6">
                       
                                    <form method="post">
                                        <label>Change Username</label>
                                        <input type="text" name="uname" class="form-control" autocomplete="off"><br>
                                        <input type="submit" name="change" class="btn btn-success" value="Change">
                                    </form>

                                    <br>

                                    <?php

                                        if (isset($_POST['update_pass'])){

                                            $old_pass = $_POST['old-pass'];
                                            $new_pass = $_POST['new-pass'];
                                            $con_pass = $_POST['con-pass'];

                                            $error = array();

                                            $old= mysqli_query($connect,"SELECT * FROM admin WHERE username='$ad'");
                                            $row = mysqli_fetch_array($old);
                                            $pass = $row['password'];

                                            if (empty($old_pass)) {
                                                $error['p'] = "Enter old password";
                                            }else if (empty($new_pass)) {
                                                $error['p'] = "Enter new password";
                                            }else if (empty($con_pass)) {
                                                $error['p'] = "Confirm password";
                                            }else if ($old_pass != $pass) {
                                                $error['p'] = "Invalid old password";
                                            }else if ($new_pass != $con_pass) {
                                                $error['p'] = "Both password does not match";
                                            }
                                            

                                            if (count($error)==0) {
                                                $query = "UPDATE admin SET password='$new_pass' WHERE username='$ad'";

                                                mysqli_query($connect,$query);
                                            }

                                    }

                                    if (isset($error['p'])) {
                                        $e = $error['p'];

                                        $show = "<h5 class='text-center alert alert-danger'>$e</h5>";
                                    }else{
                                        $show = "";
                                        
                                    }
                                    ?>

                                    <form method="post">
                                        <h5 class="text-center my-4">Change Password</h5>
                                        <div>
                                            <?php 
                                            echo $show;
                                            ?>
                                        </div>

                                        <div class="form-group">
                                            <label>Old Password</label>
                                            <input type="password" name="old-pass" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" name="new-pass" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input type="password" name="con-pass" class="form-control">
                                        </div>

                                        <input type="submit" name="update_pass" value="Update Password" class="btn btn-info">
                                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
