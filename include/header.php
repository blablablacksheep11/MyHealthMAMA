<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-info bg-pink" style="position: sticky; top:0%; z-index:3">
        <h5 class="text-white">MyHealthMAMA</h5>
        
        <div class="mr-auto"></div>

        <ul class="navbar-nav">
            <?php
            if (isset($_SESSION['admin'])) {
                $user = $_SESSION['admin'];
                    echo '
                    <li class="nav-item"><a href="profile.php" class="nav-link bg-pink text-white">'.$user.'</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link bg-pink text-white">Logout</a></li>';
                    
        }else if(isset($_SESSION['doctor'])) {
                $user = $_SESSION['doctor'];
                    echo '
                <li class="nav-item"><a href="profile.php" class="nav-link bg-pink text-white">'.$user.'</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link bg-pink text-white">Logout</a></li>';

        }else if(isset($_SESSION['nurse'])) {
                $user = $_SESSION['nurse'];
                echo '
                <li class="nav-item"><a href="profile.php" class="nav-link bg-pink text-white">'.$user.'</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link bg-pink text-white">Logout</a></li>';
            
        }else if(isset($_SESSION['mother'])) {
                $user = $_SESSION['mother'];
            echo '
                <li class="nav-item"><a href="profile.php" class="nav-link bg-pink text-white">'.$user.'</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link bg-pink text-white">Logout</a></li>';
        }
            ?>
</ul>
</nav>


<style>
.bg-pink {
    background-color: #89CFF0;
}   
h6{
    left:550px;
    position: relative;
}

</style>

</body>
</html> 