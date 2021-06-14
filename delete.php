<?php

$servername="localhost";
$username="root";
$password="";
$database="crud";
$connect=mysqli_connect($servername,$username,$password,$database);

$SNO=$_GET['id'];
$mysql="DELETE FROM `notes` WHERE `S.NO` = '$SNO' ";
$result=mysqli_query($connect,$mysql);

header('location:crud.php');
?>