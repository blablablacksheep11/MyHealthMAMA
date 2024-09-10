    <?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include("../include/header.php");
    include("../include/connection.php");

    // Check if the doctor is logged in
    if (!isset($_SESSION['username'])) {
        echo "<script>alert('Please log in first');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
        exit;
    }


    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PregnaCare +</title>
        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <style>
            .footer {
                background-color: pink;
                padding: 10px;
                color: white;
                text-align: center;
                position: fixed;
                bottom: 0;
                width: 100%;
                left: 0;
                right: 0;
            }
        </style>
    </head>
    <body style="background-image: url(img/background1.jpg);background-repeat:no-repeat; background-size:cover;">

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php include("sidenav.php"); ?>
                </div>
                <div class="col-md-10">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="my-4">Feedback Messages</h2>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Mothers</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                            // Fetch feedback data from the database
                                            $doctorUsername = $_SESSION['doctor'];
                                            $getdoctorid = "SELECT id FROM doctors WHERE username='$doctorUsername'";
                                            $result = mysqli_query($connect, $getdoctorid);
                                            $doctorid = mysqli_fetch_column($result);
                                            $feedbackQuery = "SELECT title, description,sender_username FROM feedback WHERE receiver_id='$doctorid'";
                                            $feedbackResult = mysqli_query($connect, $feedbackQuery);
                                            if (!$feedbackResult) {
                                                die("Query failed: " . mysqli_error($connect));
                                            }
                                            while ($row = mysqli_fetch_assoc($feedbackResult)) {
                                                echo "<tr>";
                                                echo "<td>" . $row['sender_username'] . "</td>";
                                                echo "<td>" . $row['title'] . "</td>";
                                                echo "<td>" . $row['description'] . "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>

    </body>
    </html>
