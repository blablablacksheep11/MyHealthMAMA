<?php 

include("../include/connection.php");

$id = $_POST['id'];

$query = "UPDATE nurses SET status='Approved' WHERE id='$id'";

mysqli_query($connect,$query);