<?php
session_start();
require("../config/database.php");
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header("location: ../sign-in.php");
}
$id = $_POST['catid'];
$userid = $_POST['userid'];
$username = $_SESSION['username'];
$result = mysqli_query($conn, "SELECT * FROM users WHERE mr_art_export_username='$username'");
        $user = mysqli_fetch_assoc($result);
        $username = $user['mr_art_export_username'];
        $email = $user['mr_art_export_email'];
        $userid = $user['id'];
        if(isset($_POST) & !empty($_POST)){
          $name = mysqli_real_escape_string($conn, $_POST['name']);
          $urlimg = mysqli_real_escape_string($conn, $_POST['imgurl']);
          $description = mysqli_real_escape_string($conn, $_POST['description']);
          date_default_timezone_set("Asia/Kolkata");
          $date = date("Y-m-d H:i:s");
          $lowercase = strtolower($name);
          $url = str_replace(" ", "-", $lowercase);
          $checking = mysqli_query($conn, "SELECT * FROM categories WHERE cat_name='$name'");
          $rownum = mysqli_num_rows($checking);
          $query = "UPDATE `categories` SET `cat_name` = '$name', `cat_slug` = '$lowercase', `cat_desc` = '$description', `cat_image` = '$urlimg', `user_id` = '$userid', `modified` = '$date' WHERE `categories`.`id` = '$id'";
          $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
          if($result){
            $smsm = "Category Added Successfully.";
            header("Location: ../categories.php");
          } else {
            $smsm = "Form Submission Failed";
          }
        }
?>