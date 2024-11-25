<?php
session_start();
include("../include/connection.php");

if (isset($_POST["update"])) {
    $id = $_SESSION["id"];
    $newfname = $_POST['fname'];
    $newsname = $_POST['sname'];
    $newdob = $_POST['dob'];
    $newphone = $_POST['phone'];
    $newemail = $_POST['email'];
    $newuname = $_POST['uname'];
    $newpass = $_POST['pass'];

    $query = "SELECT username FROM mothers WHERE id='$id'";
    $result = mysqli_query($connect, $query);
    $motherusername = mysqli_fetch_column($result);


    $query = "UPDATE mothers SET firstname='$newfname', surname='$newsname', dob='$newdob', phone='$newphone', email='$newemail', username='$newuname', password='$newpass' WHERE id='$id'";
    $res = mysqli_query($connect, $query);
    if ($res) {
        echo "<script>alert('Information updated.')</script>";
        header("Location: mother.php");
    } else {
        echo "<script>alert('Update failed.')</script>";
        header("Location:" . $_SERVER["PHP_SELF"]);
    }
    $query = "UPDATE feedback SET sender_username='$newuname' WHERE sender_username='$motherusername'";
    $res = mysqli_query($connect, $query);
    $query = "UPDATE videos SET mother_name='$newuname' WHERE mother_name='$motherusername'";
    $res = mysqli_query($connect, $query);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>MyHealthMAMA</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .footer {
            background-color: pink;
            padding: 10px;
            color: white;
            text-align: center;
        }

        .custom-container {
            margin-left: 300px;
        }
    </style>
</head>

<body style="background-image: url(img/background1.jpg);background-repeat:no-repeat; background-size:cover;">

    <?php include("../include/header.php"); ?>
    <div class="custom-container">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-md-8 jumbotron my-2">
                        <h5 class="text-center text-info my-2">Edit Information</h5>
                        <br>
                        <?php
                        $firstname = $_SESSION["firstname"];
                        $surname = $_SESSION["surname"];
                        $email = $_SESSION["email"];
                        $dob = $_SESSION["dob"];
                        $phone = $_SESSION["phone"];
                        $username = $_SESSION["username"];
                        $password = $_SESSION["password"];
                        ?>
                        <form method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Firstname</label>
                                    <input type="text" name="fname" class="form-control" autocomplete="off" placeholder="Enter Firstname" value="<?php echo $firstname ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Surname</label>
                                    <input type="text" name="sname" class="form-control" autocomplete="off" placeholder="Enter Surname" value="<?php echo $surname ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="dob">Date of Birth:</label>
                                    <input type="date" id="dob" name="dob" class="form-control" value="<?php echo $dob ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">Phone Number:</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" autocomplete="off" placeholder="Enter Phone Number" value="<?php echo $phone ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email Address:</label>
                                    <input type="email" id="email" name="email" class="form-control" autocomplete="off" placeholder="Enter Email Address" value="<?php echo $email ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Username</label>
                                    <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Enter Username" value="<?php echo $username ?>" required>
                                </div>
                            </div>
                            <div class="form-row" style="display:flex; justify-content: center">
                                <div class="form-group col-md-6">
                                    <label>Password</label>
                                    <input type="password" name="pass" class="form-control" autocomplete="off" placeholder="Enter Password" value="<?php echo $password ?>" required>
                                </div>
                            </div>
                            <div class="text-center">
                                <input type="submit" value="Update" name="update" class="btn btn-info my-2">
                                <a href="mother.php">
                                    <input type="button" value="Cancel" class="btn btn-success" style="background-color: grey;border: none">
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
//else if (empty($FakRisiko)) {
//  $error['ac'] = "Enter Faktor Risiko";
//} 
?>