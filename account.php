<?php

include("include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $FakRisiko = $_POST['FakRisiko'];
    $citizen = $_POST['citizen'];
    $THA = $_POST['THA'];
    $TAL = $_POST['TAL'];
    $RE = $_POST['RE'];
    $Gravida = $_POST['gv'];
    $Para = $_POST['Para'];
    $No_pengen = $_POST['penge'];
    $education = $_POST['Education'];
    $pekerjaan = $_POST['work'];
    
    $error = [];

    if (empty($fname)) {
        $error['ac'] = "Enter Firstname";
    } else if (empty($sname)) {
        $error['ac'] = "Enter Surname";
    } else if (empty($dob)) {
        $error['ac'] = "Enter Date of Birth";
    } else if (empty($phone)) {
        $error['ac'] = "Enter Phone Number";
    } else if (empty($email)) {
        $error['ac'] = "Enter Email";
    } else if (empty($address)) {
        $error['ac'] = "Enter Address";
    } else if (empty($due_date)) {
        $error['ac'] = "Enter Expected Due Date";
    } else if (empty($obstetric_history)) {
        $error['ac'] = "Enter Obstetric History";
    } else if (empty($medical_conditions)) {
        $error['ac'] = "Enter Medical Conditions";
    } else if (empty($uname)) {
        $error['ac'] = "Enter Username";
    } else if (empty($pass)) {
        $error['ac'] = "Enter Password";
    } else if (empty($kad_pengenalan)) {
        $error['ac'] = "Enter Kad Pengenalan";
    } else if (empty($race)) {
        $error['ac'] = "Enter Race";
    } else if (empty($FakRisiko)) {
        $error['ac'] = "Enter Faktor Risiko";
    } else if (empty($citizen)) {
        $error['ac'] = "Enter Citizen Status";
    } else if (empty($THA)) {
        $error['ac'] = "Enter THA";
    } else if (empty($TAL)) {
        $error['ac'] = "Enter TAL";
    } else if (empty($RE)) {
        $error['ac'] = "Enter RE";
    } else if (empty($Gravida)) {
        $error['ac'] = "Enter Gravida";
    } else if (empty($Para)) {
        $error['ac'] = "Enter Para";
    } else if (empty($No_pengen)) {
        $error['ac'] = "Enter No Pengen";
    } else if (empty($education)) {
        $error['ac'] = "Enter Education";
    } else if (empty($pekerjaan)) {
        $error['ac'] = "Enter Pekerjaan";
    } else if ($con_pass != $pass) {
        $error['ac'] = "Both passwords do not match";
    } else if (count($error) == 0) {
        $query = "INSERT INTO mothers (firstname, surname, dob, phone, email, address, due_date, obstetric_history, medical_conditions, username, password, citizen, THA, TAL, RE, gv, Para, Penge, work, FakRisiko, kad_pengenalan, education) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $connect->prepare($query)) {
            $stmt->bind_param('ssssssssssssssssssssss', $fname, $sname, $dob, $phone, $email, $address, $due_date, $obstetric_history, $medical_conditions, $uname, $pass, $citizen, $THA, $TAL, $RE, $Gravida, $Para, $No_pengen, $pekerjaan, $FakRisiko, $kad_pengenalan, $education);
            if ($stmt->execute()) {
                header("Location: motherlogin.php");
            } else {
                echo "<script>alert('failed to insert data')</script>";
            }
            $stmt->close();
        } else {
            echo "Failed to prepare the SQL statement.";
        }
    }
}
$connect->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
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
<body style="background-image: url(img/background1.jpg);background-repeat:no-repeat; background-size:cover;">

<?php include("include/header.php"); ?>
<div class="custom-container">
<div class="container-fluid">
    <div class="col-md-12">
        <div class="row justify-content-center">
            <div class="col-md-8 jumbotron my-2">
                <h5 class="text-center text-info my-2">Registration</h5>
                <form method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Firstname</label>
                            <input type="text" name="fname" class="form-control" autocomplete="off" placeholder="Enter Firstname">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Surname</label>
                            <input type="text" name="sname" class="form-control" autocomplete="off" placeholder="Enter Surname">
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
                            <textarea id="obstetric_history" name="obstetric_history" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="medical_conditions">Existing Medical Conditions:</label>
                            <textarea id="medical_conditions" name="medical_conditions" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Kad Pengenalan</label>
                            <input type="text" name="kad_pengenalan" class="form-control" autocomplete="off" placeholder="Enter Kad Pengenalan">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Gravida</label>
                            <input type="text" name="gv" class="form-control" autocomplete="off" placeholder="Enter Gravida">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Race</label>
                            <input type="text" name="race" class="form-control" autocomplete="off" placeholder="Enter Race">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>No Pengenalan</label>
                            <input type="text" name="penge" class="form-control" autocomplete="off" placeholder="Enter No Pengenalan">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Faktor Risiko</label>
                            <input type="text" name="FakRisiko" class="form-control" autocomplete="off" placeholder="Faktor Risiko" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Pekerjaan</label>
                            <input type="text" name="work" class="form-control" autocomplete="off" placeholder="Enter Pekerjaan">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Education</label>
                            <input type="text" name="Education" class="form-control" autocomplete="off" placeholder="Enter Education Level">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Citizen Status</label>
                            <input type="text" name="citizen" class="form-control" autocomplete="off" placeholder="Enter Citizen Status">
                        </div>
                        <div class="form-group col-md-6">
                            <label>THA</label>
                            <input type="text" name="THA" class="form-control" autocomplete="off" placeholder="Enter THA">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>TAL</label>
                            <input type="text" name="TAL" class="form-control" autocomplete="off" placeholder="Enter TAL">
                        </div>
                        <div class="form-group col-md-6">
                            <label>RE</label>
                            <input type="text" name="RE" class="form-control" autocomplete="off" placeholder="Enter RE">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Para</label>
                            <input type="text" name="Para" class="form-control" autocomplete="off" placeholder="Enter Para">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Username</label>
                            <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Enter Username">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Password</label>
                            <input type="password" name="pass" class="form-control" autocomplete="off" placeholder="Enter Password">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Confirm Password</label>
                            <input type="password" name="con_pass" class="form-control" autocomplete="off" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" value="Register" class="btn btn-info my-2">
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
