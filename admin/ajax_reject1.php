<?php 

include("../include/connection.php");

$id = $_POST['id'];

$query = "UPDATE nurses SET status='Rejected' WHERE id='$id'";

mysqli_query($connect,$query);