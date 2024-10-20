<?php
session_start();
include("../include/connection.php");

$feedbackid = $_SESSION["feedbackid"];
$reply = $_POST["reply"];

$sql="UPDATE feedback SET reply='$reply' WHERE id='$feedbackid'";
mysqli_query($connect,  $sql);

?>