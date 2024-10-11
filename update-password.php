<?php
session_start();
include("include/connection.php");

$password = $_POST["password"];
$email = $_SESSION["email"];
$entity = $_SESSION["entity"];
$entity = (string)$entity;

$sql = "UPDATE $entity SET password = '$password' WHERE email = '$email'";
mysqli_query($connect, $sql);
    