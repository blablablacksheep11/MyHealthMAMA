<?php
session_start();
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
                <h5>Doctor Dashboard</h5>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3 my-2 bg-success mx-2" style="height: 150px;">

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="text-white my-4">My Profile</h5>
                                </div>
                                <div class="col-md-4">
                                    <a href="profile.php"><i class="fa fa-user-circle fa-3x my-4"style="color: white;"></i></a>
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="col-md-3 my-2 bg-info mx-2" style="height: 150px;">

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="text-white my-4">Maternal Health Record</h5>
                                </div>
                                <div class="col-md-4">
                                    <a href="maternal_health.php"><i class="fa fa-procedures fa-3x my-4"style="color: white;"></i></a>
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="col-md-3 my-2 bg-danger mx-2" style="height: 150px;">

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="text-white my-4">Appoinment</h5>
                                </div>
                                <div class="col-md-4">
                                    <a href="appoinment.php"><i class="fa fa-clock fa-3x my-4"style="color: white;"></i></a>
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="col-md-3 my-2 bg-warning mx-2" style="height: 150px;">

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="text-white my-4">Report</h5>
                                </div>
                                <div class="col-md-4">
                                    <a href="report.php"><i class="fa fa-flag fa-3x my-4"style="color: white;"></i></a>
                                </div>
                            </div>
                        </div>
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