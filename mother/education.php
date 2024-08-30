<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../include/header.php");
include("../include/connection.php");

if (!isset($_SESSION['mother_username'])) {
    // Redirect to login page if mother is not logged in
    header("Location: motherlogin.php");
    exit();
}

$motherUsername = $_SESSION['mother_username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education Module - Mother Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url(img/background1.jpg);
            background-repeat: no-repeat;
            background-size: cover;
        }
        .video-wrapper {
            margin-bottom: 20px;
        }
        .uploaded-video {
            width: 100%;
            max-width: 320px;
            height: auto;
        }
        .footer {
            background-color: pink;
            padding: 10px;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>

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
                    <h2 class="my-4">Education Module - Mother Dashboard</h2>

                    <h3>Uploaded Videos:</h3>
                    <div class="row">
                    <?php
                        // Fetch uploaded videos for the logged-in mother from nurse/uploads and display them
                        $videoQuery = "SELECT video_path FROM videos WHERE mother_name = '$motherUsername'";
                        $videoResult = mysqli_query($connect, $videoQuery);
                        if (!$videoResult) {
                            die("Query failed: " . mysqli_error($connect));
                        }
                        if (mysqli_num_rows($videoResult) > 0) {
                            while ($videoRow = mysqli_fetch_assoc($videoResult)) {
                                $videoPath = $videoRow['video_path'];
                                echo "<div class='col-md-4'>";
                                echo "<div class='video-wrapper'>";
                                echo "<video controls class='uploaded-video'>";
                                echo "<source src='../nurse/uploads/$videoPath' type='video/mp4'>";
                                echo "Your browser does not support HTML5 video.";
                                echo "</video>";
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No videos uploaded yet.</p>";
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
