<?php
session_start();
require("config/database.php");
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header("location: ../sign-in.php");
}
$id = $_POST['id'];
$userid = $_POST['uid'];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	if(isset($_FILES['files'])){
		$errors = array();
		$path = 'uploads/';
		$extensions = ['jpg', 'jpeg', 'png', 'gif'];
		$all_files = count($_FILES['files']['tmp_name']);
		for($i=0; $i < $all_files; $i++){
			$file_name = $_FILES['files']['name'][$i];
			$file_tmp = $_FILES['files']['tmp_name'][$i];
			$file_type = $_FILES['files']['type'][$i];
			$file_size = $_FILES['files']['size'][$i];
			$tmp = explode('.', $_FILES['files']['name'][$i]);
			$file_ext = strtolower(end($tmp));
			$file = $path . $file_name;
			if(!in_array($file_ext, $extensions)) {
				array_push($errors, 'Extension not Allowed: ' . $file_name . ' ' . $file_type); 
			}

			if($file_size > 2097152) {
				array_push($errors, 'File size exceeds limit: '. $file_name . ' ' . $file_type);
			}

			if(file_exists($file)){
				$errors= "<div class='alert alert-danger' role='alert'>File is already exist. Name:- ". $file_name."</div>";
			}

			if(empty($errors)) {
				$filename = basename($file_name, $file_ext);
				move_uploaded_file($file_tmp, $file);
				date_default_timezone_set("Asia/Kolkata");
				$date = date('Y-m-d H:i:s');
				$query = "INSERT INTO product_images(product_id, ImagePath, ImageFileName, userid, created, modified) VALUES ('$id', '$path', '$file_name', '$userid', '$date', '$date')";
				mysqli_query($conn, $query);
				echo "<div class='alert alert-success' role='alert'>File is successfully Uploaded. Name:- ". $file_name."</div>";
			}
		}
		if($errors) print_r($errors);
	}
}
?>
