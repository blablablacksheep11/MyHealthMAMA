<?php

include("../include/connection.php");
session_start();

if (isset($_POST['updatebutton'])) {
    
    $id = $_SESSION["id"];
    $newfirstname = $_POST['fname'];
    $newsurname = $_POST['sname'];
    $newemail = $_POST['email'];
    $newgender = $_POST['gender'];
    $newphone = $_POST['phone'];
    $newusername = $_POST['uname'];
    $newpassword = $_POST['pass'];

    
        $query = "UPDATE nurses SET firstname='$newfirstname', surname='$newsurname', email='$newemail', gender='$newgender', phone='$newphone', username='$newusername', password='$newpassword' WHERE id='$id'";
        $res = mysqli_query($connect, $query);
        if($res){
            echo "<script>alert('Information updated.')</script>";
            header("Location: nurse.php");
        }else{
            echo "<script>alert('Update failed.')</script>";
            header("Location:".$_SERVER["PHP_SELF"]);
        }
    }


?>

<!DOCTYPE html>
<html>
<head>
        <title>MyHealthMAMA</title>
</head>
<body style="background-image: url(img/background3.jpg);background-repeat:no-repeat; background-size:cover;">
<style>
        .footer {
            background-color: #89CFF0;
            padding: 23px;
            color: white;
            text-align: center;
        }
        </style>

<?php
    include("../include/header.php");
    $firstname = $_SESSION["firstname"];
    $surname = $_SESSION["surname"];
    $email = $_SESSION["email"];
    $gender = $_SESSION["gender"];
    $phone = $_SESSION["phone"];
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    ?>

<div class= "container-fluid">
<div class="col-md-12">
     <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 jumbotron my-3">
        <h5 class="text-center my-2">Edit Information</h5>

        <form method="post">
                <div class="form-group">
                    <label>Firstname</label>
                    <input type="text" name="fname"class="form-control" autocomplete="off" placeholder="Enter Firstname" 
                    value="<?php echo $firstname ?>" required>
                </div>

                <div class="form-group">
                    <label>Surname</label>
                    <input type="text" name="sname"class="form-control" autocomplete="off" placeholder="Enter Surname"
                    value="<?php echo $surname ?>" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email"class="form-control" autocomplete="off" placeholder="Enter Email Address"
                    value="<?php echo $email ?>" required>
                </div>

                <div class="form-group">
                    <label>Select Gender</label>
                    <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="male" value="Male" required>
                <label class="form-check-label" for="male">Male</label>
            </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="female" value="Female">
                <label class="form-check-label" for="female">Female</label>
                </div>
                <?php
                if($gender=='Male'){
                    echo "<script> document.getElementById('male').checked = true;</script>";
                }
                if($gender=='Female'){
                    echo "<script> document.getElementById('female').checked = true;</script>";
                }
                ?>
            </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="number" name="phone" class="form-control" autocomplete="off" placeholder="Enter Phone Number"
                    value="<?php echo $phone ?>" required>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Enter Username"
                    value="<?php echo $username ?>" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="pass" class="form-control" autocomplete="off" placeholder="Enter Password" value="<?php echo $password ?>" required>
                </div>


                <input type="submit" name="updatebutton" value="Update" class="btn btn-success">
                <a href="nurse.php">
                <input type="button" value="Cancel" class="btn btn-success" style="background-color: grey;border: none">
                </a>

        </form>
        </div>
        <div class="col-md-3"></div>
     </div>
</div>
</div>

<div class="footer">
        <p></p>
    </div>

</body>
</html>