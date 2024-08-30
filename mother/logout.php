<?php
session_start();

if (isset($_SESSION['mother'])) {
    
    unset($_SESSION['mother']);
        
    header("Location: ../index.php");
}
?>