<?php
include("../include/connection.php");
session_start();

if(isset($_POST["editbutton"])){
    $selectednurseid = $_POST["editbutton"];
    $getnurseinfo = "SELECT * FROM nurses WHERE id='$selectednurseid'";
    $result = mysqli_query($connect, $getnurseinfo);
    $nurseinfo = mysqli_fetch_assoc($result);

    //store data into session
    $_SESSION["id"] = $selectednurseid;
    $_SESSION["firstname"] = $nurseinfo["firstname"];
    $_SESSION["surname"] = $nurseinfo["surname"];
    $_SESSION["email"] = $nurseinfo["email"];
    $_SESSION["gender"] = $nurseinfo["gender"];
    $_SESSION["phone"] = $nurseinfo["phone"];
    $_SESSION["username"] = $nurseinfo["username"];
    $_SESSION["password"] = $nurseinfo["password"];

    header("Location: edit-nurse-info.php");
}

if(isset($_POST["removebtn"])){
    $selectednurseid = $_POST["removebtn"];
    $deletenurseinfo = "DELETE FROM nurses WHERE id='$selectednurseid'";
    mysqli_query($connect, $deletenurseinfo);

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>MyHealthMAMA</title>
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

    <div class="container=fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">

                <?php
                include("sidenav.php");
                ?>

                </div>
                <div class="col-md-10">
                    
                    <h5 class="text-center">Total Nurses</h5>

                <?php 
                
                $query = "SELECT * FROM nurses WHERE status='Approved' ORDER BY password ASC";

                $res = mysqli_query($connect, $query);

                $output ="";

$output .="

    <table class='table table-bordered'>
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
        <td colspan='10' class='text-center'>No Nurse Registered Yet.</td>
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