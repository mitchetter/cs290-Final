<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include 'pwd.php';

$value = 'yes'; 

$mysqli = new mysqli("oniddb.cws.oregonstate.edu","etterm-db",$passwd,"etterm-db");
if(!$mysqli || $mysqli->connect_errno) {
	echo "Connection Error ".$mysqli->connect_errno ." ".$mysqli->connect_error;
}
//query for all rented videos
$result = mysqli_query($mysqli, "SELECT * FROM videoQueue WHERE liked = 'yes'");
while($row = $result->fetch_assoc()){
    if($row['id'] == $_GET['indexkey']) {
    	$value = 'no';
    }
}

$stmt = $mysqli->prepare("UPDATE videoQueue SET liked = '$value' WHERE id = ?");
$stmt->bind_param('i', $_GET['indexkey']);
$stmt->execute(); 
$stmt->close();

mysqli_close($mysqli);
header("refresh:3;url=interface.php" );
echo "<h3>Toggling Like/Unlike...</h3>";
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