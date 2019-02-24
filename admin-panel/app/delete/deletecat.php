<?php
session_start();
require("../config/database.php");
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header("location: ../sign-in.php");
}
$id = $_GET['id'];
$delquery = mysqli_query($conn, "DELETE FROM `categories` WHERE `categories`.`id` = '$id'");
if(delquery){
	header("location: ../categories.php");
}
?>