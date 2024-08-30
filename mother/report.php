<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../include/header.php");
include("../include/connection.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input data if set
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $senderUsername = isset($_SESSION['username']) ? $_SESSION['username'] : '';

    // Insert feedback data into database if input is not empty
    if (!empty($title) && !empty($description)) {
        $insertQuery = "INSERT INTO feedback (title, description, sender_username) VALUES ('$title', '$description', '$senderUsername')";
        if (mysqli_query($connect, $insertQuery)) {
            echo "<script>alert('Feedback submitted successfully');</script>";
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($connect);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
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
                        <div class="col-md-6">
                            <h2 class="my-4">Feedback Form</h2>
                            <form method="post">
<div class="form-group">
    <label for="title">Title:</label>
    <input type="text" class="form-control" id="title" name="title" required>
</div>
<div class="form-group">
    <label for="description">Description:</label>
    <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
</div>
<input type="hidden" name="mother_username" value="<?php echo $_SESSION['username']; ?>">
<button type="submit" class="btn btn-success">Submit Feedback</button>

                            </form>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>

</body>
</html>
