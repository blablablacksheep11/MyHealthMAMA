<?php
include("../include/connection.php");
session_start();

if(isset($_POST["editbutton"])){
    $selecteddocid = $_POST["editbutton"];
    $getdocinfo = "SELECT * FROM doctors WHERE id='$selecteddocid'";
    $result = mysqli_query($connect, $getdocinfo);
    $docinfo = mysqli_fetch_assoc($result);

    //store data into session
    $_SESSION["id"] = $selecteddocid;
    $_SESSION["firstname"] = $docinfo["firstname"];
    $_SESSION["surname"] = $docinfo["surname"];
    $_SESSION["email"] = $docinfo["email"];
    $_SESSION["gender"] = $docinfo["gender"];
    $_SESSION["phone"] = $docinfo["phone"];
    $_SESSION["username"] = $docinfo["username"];
    $_SESSION["password"] = $docinfo["password"];

    header("Location: edit-doctor-info.php");
}

if(isset($_POST["removebtn"])){
    $selecteddocid = $_POST["removebtn"];
    $deletedocinfo = "DELETE doctors.*,appointments.*,feedback.* FROM doctors INNER JOIN appointments ON doctors.username=appointments.doctor_name INNER JOIN feedback ON doctors.id=feedback.receiver_id WHERE doctors.id='$selecteddocid'";
    mysqli_query($connect, $deletedocinfo);

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>PregnaCare +</title>
    <style>
        .footer {
            background-color: pink;
            padding: 10px;
            color: white;
            text-align: center;
        }

        #formcontainer{
            position: absolute;
            border: 1px solid black;
            border-radius: 10px;
            height: 50vh;
            width: 40vw;
            left: 20%;
            top: 20%;
            background-color: white;
        }
        </style>
</head>
<body style="background-image: url(img/background1.jpg);background-repeat:no-repeat; background-size:cover;">

    <?php
    include("../include/header.php");
    ?>

    <div class="container=fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">

                <?php
                include("sidenav.php");
                ?>

                </div>
                <div class="col-md-10">
                    <!--<div id="formcontainer"></div>-->
                    <h5 class="text-center">Total Doctors</h5>

                <?php 
                
                $query = "SELECT * FROM doctors WHERE status='Approved' ORDER BY password ASC";

                $res = mysqli_query($connect, $query);

                $output ="";

$output .="

    <table class='table table-bordered' style='overflow: auto'>
    <tr>
        <th>ID</th>
        <th>Firstname</th>
        <th>Surname</th>
        <th>Email</th>
        <th>Gender</th>
        <th>Phone</th>
        <th>Username</th>
        <th>Password</th>
        <th>Actions</th>
    </tr>
";

if (mysqli_num_rows($res) < 1){

    $output .="

        <tr>
        <td colspan='10' class='text-center'>No Doctor Registered Yet.</td>
        </tr>
    ";
}

while ($row = mysqli_fetch_assoc($res)){

    $output .="
    
        <tr>
        <td>".$row['id']."</td>
        <td>".$row['firstname']."</td>
        <td>".$row['surname']."</td>
        <td>".$row['email']."</td>
        <td>".$row['gender']."</td>
        <td>".$row['phone']."</td>
        <td>".$row['username']."</td>
        <td>".$row['password']."</td>
        <td>
        <form method='post'><button type='submit' class='btn btn-primary' name='editbutton' value=".$row['id'].">Edit</button>
        <button id='removebtn' name='removebtn' class='btn btn-primary' style='background-color: red; border: none;' value=".$row['id'].">Remove</button>
        </form></td>
    
    ";
}

$output .="

    </tr>
</table>

";

echo $output;
                
                ?>

                </div>
            </div>
        </div>
    </div>


</body>
</html>