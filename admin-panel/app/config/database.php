<?php 
$conn = mysqli_connect("localhost", "root", "", "mrartexports");

if(!$conn) {
	echo "Error: Unable to connect to database.". PHP_EOL;
	echo "Debugging error: ".mysqli_connect_error().PHP_EOL;
	exit;
}

?>