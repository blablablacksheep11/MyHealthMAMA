<?php
include("include/header.php");
session_start();
include("include/connection.php");

// Handle Mother login
if (isset($_POST['mother_login'])) {
    $uname = $_POST['uname']; 
    $pass = $_POST['pass'];

    if (empty($uname)) {
        echo "<script>alert('Enter Username')</script>";
    } else if (empty($pass)) {
        echo "<script>alert('Enter Password')</script>";
    } else {
        $query = "SELECT * FROM mothers WHERE username='$uname' AND password='$pass'";
        $res = mysqli_query($connect, $query);
        $valuereturned = mysqli_fetch_assoc($res);
        

        if (mysqli_num_rows($res) == 1) {
            $_SESSION['mother'] = $uname;
            $_SESSION['username'] = $uname;
            $_SESSION['mother_username'] = $uname;
            $_SESSION['mother_id'] = $valuereturned["id"];
            unset($_SESSION['admin']);
            unset($_SESSION['doctor']);
            unset($_SESSION['nurse']);
            
            header("Location: mother/index.php");
            exit();
        } else {
            echo "<script>alert('Invalid Account')</script>";
        }
    }
}

// Handle Admin login
if (isset($_POST['admin_login'])) {
    $username = $_POST['uname'];
    $password = $_POST['pass'];

    $error = array();

    if (empty($username)) {
        $error['admin'] = "Enter Username";
    } else if (empty($password)) {
        $error['admin'] = "Enter Password";
    }

    if (count($error) == 0) {
        $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['admin'] = $username;
            unset($_SESSION['mother']);
            unset($_SESSION['doctor']);
            unset($_SESSION['nurse']);
            header("Location: admin/index.php");
            exit();
        } else {
            echo "<script>alert('Invalid username or password')</script>";
        }
    }
}

// Handle Doctor login
if (isset($_POST['doctor_login'])) {
    $username = $_POST['uname'];
    $password = $_POST['pass'];

    $error = array();

    if (empty($username)) {
        $error['doctor'] = "Enter Username";
    } else if (empty($password)) {
        $error['doctor'] = "Enter Password";
    }

    if (count($error) == 0) {
        $query = "SELECT * FROM doctors WHERE username='$username' AND password='$password' AND status='Approved'";
        $result = mysqli_query($connect, $query);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $_SESSION['doctor'] = $username;
            unset($_SESSION['admin']);
            unset($_SESSION['mother']);
            unset($_SESSION['nurse']);
            header("Location: doctor/index.php");
            exit();
        } else {
            $error['doctor'] = "Invalid username or password";
        }
    }
}

// Handle Nurse login
if (isset($_POST['nurse_login'])) {
    $username = $_POST['uname'];
    $password = $_POST['pass'];

    $error = array();

    if (empty($username)) {
        $error['nurse'] = "Enter Username";
    } else if (empty($password)) {
        $error['nurse'] = "Enter Password";
    }

    if (count($error) == 0) {
        $query = "SELECT * FROM nurses WHERE username='$username' AND password='$password' AND status='Approved'";
        $result = mysqli_query($connect, $query);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $_SESSION['nurse'] = $username;
            unset($_SESSION['admin']);
            unset($_SESSION['doctor']);
            unset($_SESSION['mother']);
            header("Location: nurse/index.php");
            exit();
        } else {
            $error['nurse'] = "Invalid username or password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyHealthMAMA</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Your existing CSS styles */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            outline: none;
            border: none;
            text-decoration: none;
            transition: all .2s linear;
        }

        .home {  
            max-height: 93vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .content {
            flex: 50%;
            padding: 0 2rem;
        }

        .content h3 {
            font-size: 3rem;
            color: var(--black);
            margin-bottom: 25rem;
        }

        .content h3 span {
            color: #6082B6;
        }

        .content p {
            font-size: 1.5rem;
            color: var(--light-color);
            line-height: 1.8;
            padding-bottom: 2rem;
        }

        .image {
            flex: 1 1 50%;
            text-align: center;
            max-width: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            max-height: 100vh;
        }

        .image .img {
            max-width: 85.7%;
            max-height: 20%;
            margin-top:110px; /* Center the image horizontally */
        }

        .footer {
            background-color: pink;
            padding: 27px;
            color: white;
            text-align: center;
        }

        .container-fluid {
            right: 355px;
            position: absolute;
            bottom: 30px;
        }

        .login-form input[type="submit"] {
            margin-top: 10px; /* Adjust as needed for spacing */
            background-color: #007bff; /* Blue color example, adjust as per your design */
            color: #ffffff; /* Text color for the button */
            padding: 10px 20px; /* Padding for the button */
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .login-form input[type="submit"]:hover {
            background-color: #0056b3; /* Darker shade of blue on hover */
        }

        .form-group input[type="radio"] {
            left: 190px;
            position: relative;
        }

        .radiolabel {
            position: relative;
            left: 190px;
        }

        .form-container {
            position: fixed;
            top: 55%;
            left: 27%;
            transform: translate(-50%, -50%);
            z-index: 10; /* Ensure it stays on top */
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
    <script>

        function showForm(formId) {
            var forms = document.querySelectorAll('.login-form');
            forms.forEach(form => {
                if (form.id === formId) {
                    form.style.display = 'block';
                } else {
                    form.style.display = 'none';
                }
            });
        }

        // Function to initialize default form on page load
        $(document).ready(function(){
            // Choose "Mother" radio button by default
            var motherRadio = document.querySelector('input[name="user_type"][value="mother"]');
            var adminRadio = document.querySelector('input[name="user_type"][value="admin"]');
            var nurseRadio = document.querySelector('input[name="user_type"][value="nurse"]');
            var doctorRadio = document.querySelector('input[name="user_type"][value="doctor"]');
            if (motherRadio) {
                motherRadio.checked = true; // Mark "Mother" as checked
                adminRadio.checked = false;
                doctorRadio.checked = false;
                nurseRadio.checked = false;
                showForm('motherForm'); // Show the corresponding form
            }
        })
        
    </script>
</head>
<body style="background-image: url(img/background3.jpg);background-repeat:no-repeat; background-size:cover;">

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 my-5 jumbotron form-container">
                <h5 class="text-center my-3">Login Form</h5>
                <div class="form-group">
                    <input type="radio" id="motherRadio" name="user_type" value="mother" onclick="showForm('motherForm')">
                    <label class="radiolabel" for="motherRadio">Mother</label>

                    <input type="radio" id="adminRadio" name="user_type" value="admin" onclick="showForm('adminForm')">
                    <label class="radiolabel" for="adminRadio">Admin</label>

                    <input type="radio" id="doctorRadio" name="user_type" value="doctor" onclick="showForm('doctorForm')">
                    <label class="radiolabel" for="doctorRadio">Doctor</label>

                    <input type="radio" id="nurseRadio" name="user_type" value="nurse" onclick="showForm('nurseForm')">
                    <label class="radiolabel" for="nurseRadio">Nurse</label>
                </div>

                <!-- Mother Login Form -->
                <form id="motherForm" class="login-form" method="post" style="display: none;">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="uname" id="uname" class="form-control" 
                            autocomplete="off" placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="pass" class="form-control" placeholder="Enter Password">
                        <a href="forgot-pass-mothers.php" style="right: 3%;position: absolute">Forgot Password</a>
                    </div>
                    <input type="submit" name="mother_login" class="btn btn-info my-3" value="Login">
                    <p>Don't have an account? <a href="account.php">Register here</a></p>
                </form>

                <!-- Admin Login Form -->
                <form id="adminForm" class="login-form" method="post" style="display: none;">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="uname" class="form-control" 
                            autocomplete="off" placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="pass" class="form-control" placeholder="Enter Password">
                    </div>
                    <input type="submit" name="admin_login" class="btn btn-success" value="Login">
                </form>

                <!-- Doctor Login Form -->
                <form id="doctorForm" class="login-form" method="post" style="display: none;">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="uname" class="form-control" 
                            autocomplete="off" placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="pass" class="form-control" placeholder="Enter Password">
                        <a href="forgot-pass-doctors.php" style="right: 3%;position: absolute">Forgot Password</a>
                    </div>
                    <input type="submit" name="doctor_login" class="btn btn-primary" value="Login">
                    <p>Don't have an account? <a href="apply.php">Register here</a></p>
                </form>

                <!-- Nurse Login Form -->
                <form id="nurseForm" class="login-form" method="post" style="display: none;">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="pass" class="form-control" placeholder="Enter Password">
                        <a href="forgot-pass-nurses.php" style="right: 3%;position: absolute">Forgot Password</a>
                    </div>
                    <input type="submit" name="nurse_login" class="btn btn-warning" value="Login">
                    
                    <p>Don't have an account? <a href="apply1.php">Register here</a></p>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>

<section class="home" id="home">
    <div class="content">
        <h3>Empowering Mothers <br><span>Ensuring Health</span></h3>
        <p></p>
    </div>
    <div class="image">
        <img src="img/background.png" alt="" class="img">
    </div>
</section>



</body>
</html>
