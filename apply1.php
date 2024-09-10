<?php

include("include/connection.php");

if (isset($_POST['apply'])) {
    $firstname = $_POST['fname'];
    $surname = $_POST['sname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $username = $_POST['uname'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['con_pass'];

    if($password == $confirm_password){
        $query = "INSERT INTO nurses (firstname, surname, email, gender, phone, username, password, status) VALUES ('$firstname', '$surname', '$email', '$gender', '$phone', '$username', '$password', 'Pending')";
        $res = mysqli_query($connect, $query);
        if($res){
            echo "<script>alert('Account created.')</script>";
            header("Location: index.php");
        }else{
            echo "<script>alert('Account creation failed.')</script>";
            header("Location:".$_SERVER["PHP_SELF"]);
        }
    }else{ echo"<script>alert('Password and Confirm-password must be the same.')</script>";}

}

if (isset($error['apply'])) {
    $s = $error['apply'];

    $show = "<h5 class='text-center alert alert-danger'>$s</h5>";
    }else{
    $show = "";

}


?>

<!DOCTYPE html>
<html>
<head>
        <title>PregnaCare +</title>
        <style>
        .footer {
            background-color: pink;
            padding: 23px;
            color: white;
            text-align: center;
        }
        </style>
</head>
<body style="background-image: url(img/background1.jpg);background-repeat:no-repeat; background-size:cover;">

<?php
    include("include/header.php");
    ?>

<div class= "container-fluid">
<div class="col-md-12">
     <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 jumbotron my-3">
        <h5 class="text-center my-2">Registeration</h5>
            <div>
                <?php echo $show; ?>
            </div>

        <form method="post">
                <div class="form-group">
                    <label>Firstname</label>
                    <input type="text" name="fname"class="form-control" autocomplete="off" placeholder="Enter Firstname" 
                    value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Surname</label>
                    <input type="text" name="sname"class="form-control" autocomplete="off" placeholder="Enter Surname"
                    value="<?php if(isset($_POST['sname'])) echo $_POST['sname']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email"class="form-control" autocomplete="off" placeholder="Enter Email Address"
                    value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required>
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
            </div>
            
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="number" name="phone" class="form-control" autocomplete="off" placeholder="Enter Phone Number"
                    value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Enter Username"
                    value="<?php if(isset($_POST['uname'])) echo $_POST['uname']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="pass" class="form-control" autocomplete="off" placeholder="Enter Password" required>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="con_pass" class="form-control" autocomplete="off" placeholder="Enter Confirm Password" required>
                </div>

                <input type="submit" name="apply" value="Register" class="btn btn-success">

                <p>Already have an account? <a href="index.php">Click here</a></p>

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