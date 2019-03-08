<?php
session_start();
require("../config/database.php");
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header("location: ../sign-in.php");
}
$id = $_GET['id'];
$delquery = mysqli_query($conn, "DELETE FROM `products` WHERE `products`.`id` = '$id'");
if(delquery){
    $id = $_GET['id'];
    $sql = "SELECT * FROM product_images WHERE product_id='$id'";
    $res = mysqli_query($conn, $sql);
    while($r = mysqli_fetch_assoc($res)){
    if(isset($r['ImagePath']) & !empty($r['ImagePath'])){
        if(unlink('../'.$r['ImagePath'].$r['ImageFileName'])){
    		$delsql="DELETE FROM product_images WHERE id='$id'";
    		if(mysqli_query($conn, $delsql)){
    			echo "Done";
    		}
        }
    } 
}
	header("location: ../products.php");
}
?>