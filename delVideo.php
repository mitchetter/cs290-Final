<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include 'pwd.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu","etterm-db",$passwd,"etterm-db");
if(!$mysqli || $mysqli->connect_errno) {
	echo "Connection Error ".$mysqli->connect_errno ." ".$mysqli->connect_error;
}

$stmt = $mysqli->prepare("DELETE FROM videoQueue WHERE id = ?");
$stmt->bind_param('i', $_GET['indexkey']);
$stmt->execute(); 
$stmt->close();

mysqli_close($mysqli);
header("refresh:3;url=interface.php" );
echo "<h3>Removing from queue...</h3>";

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