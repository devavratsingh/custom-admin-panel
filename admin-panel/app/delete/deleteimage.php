<?php
session_start();
require("../config/database.php");
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header("location: ../../sign-in.php");
}
if(isset($_GET['proid'])){
  $productid = $_GET['proid']; 
}
 if(isset($_GET['id']) & !empty($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM product_images WHERE id='$id'";
    $res = mysqli_query($conn, $sql);
    $r = mysqli_fetch_assoc($res);
    if(isset($r['ImagePath']) & !empty($r['ImagePath'])){
        if(unlink('../'.$r['ImagePath'].$r['ImageFileName'])){
    		$delsql="DELETE FROM product_images WHERE id='$id'";
    		if(mysqli_query($conn, $delsql)){
    			header("location: ../upload-image.php?id=".$productid);
    		}
        }
    } else {
        $delsql="DELETE FROM product_images WHERE id='$id'";
        if(mysqli_query($conn, $delsql)){
            header("location: ../upload-image.php?id=".$productid);
        }
    }
 } else {
 	header("location: ../upload-image.php?id=".$productid);
 }