<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include 'pwd.php';

//no session username exists, send back to login.php
if(!isset($_SESSION['username'])) {
	header('Location: index.php');
	exit();
}

$mysqli = new mysqli("oniddb.cws.oregonstate.edu","etterm-db",$passwd,"etterm-db");
if(!$mysqli || $mysqli->connect_errno) {
	echo "Connection Error ".$mysqli->connect_errno ." ".$mysqli->connect_error;
} 

mysqli_query($mysqli,'TRUNCATE TABLE videoQueue');
mysqli_close($mysqli);
header("refresh:3;url=interface.php" );
echo "<h3>Clearing inventory...</h3>";
?>
<!DOCTYPE html>
<html>
  <head>
  	<meta charset="utf-8">
    <!-- Bootstrap core CSS -->
    <link href="styles/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="styles/signin.css" rel="stylesheet" type="text/css">
  </head>
  <body>
  </body>
</html>  