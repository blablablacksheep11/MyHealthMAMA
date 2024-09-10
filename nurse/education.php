<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../include/header.php");
include("../include/connection.php");

// Handle form submission for uploading videos
if (isset($_POST['submit']) && isset($_FILES['videoFile'])) {
    // Get input data
    $motherUsername = isset($_POST['motherUsername']) ? $_POST['motherUsername'] : '';
    $videoName = $_FILES['videoFile']['name'];
    $tmpName = $_FILES['videoFile']['tmp_name'];
    $error = $_FILES['videoFile']['error'];

    if ($error === 0) {
        $videoExtension = pathinfo($videoName, PATHINFO_EXTENSION);
        $videoExtensionLC = strtolower($videoExtension);
        $allowedExts = array("mp4", "webm", "avi", "flv");

        if (in_array($videoExtensionLC, $allowedExts)) {
            $newVideoName = uniqid("video-", true) . '.' . $videoExtensionLC;
            $videoUploadPath = 'uploads/' . $newVideoName;
            move_uploaded_file($tmpName, $videoUploadPath);

            // Insert the video path and original name into the database
            $getmotherid = "SELECT id FROM mothers WHERE username = '$motherUsername'";
            $result = mysqli_query($connect, $getmotherid);
            $motherid = mysqli_fetch_column($result);
            $sql = "INSERT INTO videos (mother_id, mother_name, video_path, original_name) 
                    VALUES ('$motherid', '$motherUsername', '$newVideoName', '$videoName')";
            mysqli_query($connect, $sql);

            // Display alert message on successful upload
            echo "<script>alert('Video uploaded successfully');</script>";
            // Reload the same page
            echo "<script>window.location.href = 'education.php';</script>";
            exit();
        } else {
            $error_message = "You can't upload files of this type";
            header("Location: education.php?error=$error_message");
            exit();
        }
    }
}

// Handle search filter form submission
$searchUsername = '';
if (isset($_POST['search'])) {
    $searchUsername = mysqli_real_escape_string($connect, $_POST['searchUsername']);
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
    <style>
        body {
            background-image: url(img/background1.jpg);
            background-repeat: no-repeat;
            background-size: cover;
        }
        .video-wrapper {
            margin-bottom: 15px;
        }
        .uploaded-video {
            width: 100%;
            max-width: 320px;
            height: auto;
            position: relative;
            border-radius: 10px;
            display: none; /* Hide video initially */
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
                    <h2 class="my-4">Education Module - Nurse Dashboard</h2>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="motherUsername">Select Mother:</label>
                            <select class="form-control" name="motherUsername" id="motherUsername" required>
                                <option value="" disabled selected>Select Mother</option>
                                <?php
                                // Fetch list of mothers' usernames from the database
                                $motherQuery = "SELECT username FROM mothers";
                                $motherResult = mysqli_query($connect, $motherQuery);
                                if (!$motherResult) {
                                    die("Query failed: " . mysqli_error($connect));
                                }
                                while ($row = mysqli_fetch_assoc($motherResult)) {
                                    $username = $row['username'];
                                    echo "<option value='$username'>$username</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="videoFile">Upload Video:</label>
                            <input type="file" class="form-control-file" id="videoFile" name="videoFile" accept="video/mp4,video/avi,video/mov" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Upload Video</button>
                    </form>

                    <hr>

                    <form method="post">
                        <div class="form-group">
                            <label for="searchUsername">Search Mother by Username:</label>
                            <input type="text" class="form-control" id="searchUsername" name="searchUsername" placeholder="Enter mother's username">
                        </div>
                        <button type="submit" class="btn btn-primary" name="search">Search</button>
                    </form>
                    
                    <br>

                    <div class="row">
                        <?php
                        // Fetch uploaded videos for the searched mother and display them
                        if ($searchUsername !== '') {
                            $motherQuery = "SELECT DISTINCT mother_name FROM videos WHERE mother_name LIKE '%$searchUsername%'";
                        } else {
                            $motherQuery = "SELECT DISTINCT mother_name FROM videos";
                        }
                        $motherResult = mysqli_query($connect, $motherQuery);
                        if (!$motherResult) {
                            die("Query failed: " . mysqli_error($connect));
                        }
                        while ($row = mysqli_fetch_assoc($motherResult)) {
                            $motherUsername = $row['mother_name'];
                            $videoQuery = "SELECT video_path, original_name FROM videos WHERE mother_name = '$motherUsername'";
                            $videoResult = mysqli_query($connect, $videoQuery);
                            if (!$videoResult) {
                                die("Query failed: " . mysqli_error($connect));
                            }

                            $videoPaths = [];
                            while ($videoRow = mysqli_fetch_assoc($videoResult)) {
                                $videoPaths[] = ['path' => $videoRow['video_path'], 'name' => $videoRow['original_name']];
                            }

                            if (!empty($videoPaths)) {
                                echo "<div class='col-md-4'>";
                                echo "<div class='form-group'>";
                                echo "<label for='videoFormat-$motherUsername'>Videos for $motherUsername:</label>";
                                echo "<select class='form-control' id='videoFormat-$motherUsername' onchange='showVideo(this.value, \"$motherUsername\")'>";
                                echo "<option value='' disabled selected>Select Video </option>";
                                foreach ($videoPaths as $video) {
                                    $filePath = $video['path']; 
                                    $fileName = $video['name'];
                                    echo "<option value='$filePath'>$fileName</option>";
                                }
                                echo "</select>";
                                echo "</div>";
                                echo "<div class='video-wrapper'>";
                                echo "<video id='video-$motherUsername' controls class='uploaded-video'>";
                                echo "<source src='' type='video/mp4'>";
                                echo "Your browser does not support HTML5 video.";
                                echo "</video>";
                                echo "</div>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showVideo(videoPath, motherUsername) {
    var videoElement = document.getElementById('video-' + motherUsername);
    if (videoPath) {
        videoElement.querySelector('source').src = 'uploads/' + videoPath;
        videoElement.style.display = 'block'; // Show video
        videoElement.load();
    } else {
        videoElement.style.display = 'none'; // Hide video
    }
}
</script>

</body>
</html>
