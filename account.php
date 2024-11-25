<?php

include("include/connection.php");

if (isset($_POST["register"])) {
    $fname = $_POST['fname'];
    $sname = $_POST['sname'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $due_date = $_POST['due_date'];
    $obstetric_history = $_POST['obstetric_history'];
    $medical_conditions = $_POST['medical_conditions'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $con_pass = $_POST['con_pass'];
    $kad_pengenalan = $_POST['kad_pengenalan'];
    $race = $_POST['race'];
    //$FakRisiko = $_POST['FakRisiko'];
    $citizen = $_POST['citizen'];
    $THA = $_POST['THA'];
    $TAL = $_POST['TAL'];
    $RE = $_POST['RE'];
    $Gravida = $_POST['gv'];
    $Para = $_POST['Para'];
    $No_pengen = $_POST['penge'];
    $education = $_POST['Education'];
    $pekerjaan = $_POST['work'];

    if($pass == $con_pass){
        $query = "INSERT INTO mothers (firstname, surname, dob, phone, email, address, due_date, obstetric_history, medical_conditions, username, password) VALUES ('$fname', '$sname', '$dob', '$phone', '$email', '$address', '$due_date', '$obstetric_history', '$medical_conditions', '$uname', '$pass')";
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
        .custom-container
        {
            margin-left:300px;
        }
    </style>
</head>
<body style="background-image: url(img/background3.jpg);background-repeat:no-repeat; background-size:cover;">

<?php include("include/header.php"); ?>
<div class="custom-container">
<div class="container-fluid">
    <div class="col-md-12">
        <div class="row justify-content-center">
            <div class="col-md-8 jumbotron my-2">
                <h5 class="text-center text-info my-2">Registration</h5>
                <form action="account.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Firstname</label>
                            <input type="text" name="fname" class="form-control" autocomplete="off" placeholder="Enter Firstname" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Surname</label>
                            <input type="text" name="sname" class="form-control" autocomplete="off" placeholder="Enter Surname" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" id="dob" name="dob" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone Number:</label>
                            <input type="tel" id="phone" name="phone" class="form-control" autocomplete="off" placeholder="Enter Phone Number" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email Address:</label>
                            <input type="email" id="email" name="email" class="form-control" autocomplete="off" placeholder="Enter Email Address" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Address:</label>
                            <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="due_date">Expected Due Date:</label>
                            <input type="date" id="due_date" name="due_date" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="obstetric_history">Obstetric History:</label>
                            <textarea id="obstetric_history" name="obstetric_history" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="medical_conditions">Existing Medical Conditions:</label>
                            <textarea id="medical_conditions" name="medical_conditions" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label>IC Number</label>
                            <input type="text" name="kad_pengenalan" class="form-control" autocomplete="off" placeholder="Enter IC Number" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Gravida</label>
                            <input type="text" name="gv" class="form-control" autocomplete="off" placeholder="Enter Gravida" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Para</label>
                            <input type="text" name="Para" class="form-control" autocomplete="off" placeholder="Enter Para" required>
                        </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                            <label>Race</label>
                            <input type="text" name="race" class="form-control" autocomplete="off" placeholder="Enter Race" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Risk Factor</label>
                            <input type="text" name="FakRisiko" class="form-control" autocomplete="off" placeholder="Faktor Risiko" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Employment</label>
                            <input type="text" name="work" class="form-control" autocomplete="off" placeholder="Enter Employment" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Education</label>
                            <input type="text" name="Education" class="form-control" autocomplete="off" placeholder="Enter Education Level" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Citizen Status</label>
                            <input type="text" name="citizen" class="form-control" autocomplete="off" placeholder="Enter Citizen Status" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>THA</label>
                            <input type="text" name="THA" class="form-control" autocomplete="off" placeholder="Enter THA" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>TAL</label>
                            <input type="text" name="TAL" class="form-control" autocomplete="off" placeholder="Enter TAL" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>RE</label>
                            <input type="text" name="RE" class="form-control" autocomplete="off" placeholder="Enter RE" required>
                        </div>
                    </div>
                    <div class="form-row">
                        
                        <div class="form-group col-md-6">
                            <label>Username</label>
                            <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Enter Username" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Password</label>
                            <input type="password" name="pass" class="form-control" autocomplete="off" placeholder="Enter Password" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Confirm Password</label>
                            <input type="password" name="con_pass" class="form-control" autocomplete="off" placeholder="Confirm Password" required>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" value="Register" name="register" class="btn btn-info my-2">
                    </div>
                    <p class="text-center">Already have an account? <a href="index.php">Login here</a></p>
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