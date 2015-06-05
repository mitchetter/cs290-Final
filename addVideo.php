<html>
  <head>
  	<meta charset="utf-8">
    <!-- Bootstrap core CSS -->
    <link href="styles/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="styles/queue.css" rel="stylesheet" type="text/css">
  </head>
  <body>
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

$validInput = true;
$uid = $_SESSION['username'];
$newImdbID = $_SESSION['imdbID'];
$newName = $_SESSION['Title'];  
$newRating = $_SESSION['Rated'];
$newCategory = $_SESSION['Genre']; 
$newLength = $_SESSION['Runtime']; 
$newPoster = $_SESSION['Poster'];


if($validInput) {
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","etterm-db",$passwd,"etterm-db");
if(!$mysqli || $mysqli->connect_errno) {
	echo "Connection Error ".$mysqli->connect_errno ." ".$mysqli->connect_error;
} 

/* Prepared statement, stage 1: prepare */
if (!($stmt = $mysqli->prepare("INSERT INTO videoQueue(uid,imdbID,name,category,length,rated) VALUES (?,?,?,?,?,?)"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

/* Prepared statement, stage 2: bind and execute */
if (!$stmt->bind_param("ssssis", $uid,$newImdbID,$newName,$newCategory,$newLength,$newRating)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}
if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
echo "<h3>Adding $newName to your queue...</h3><br>";
?>

<!-- Code in following line makes a new API call to fetch the movie poster -->
<img src="http://img.omdbapi.com/?apikey=<?php echo $myKey?>&i=<?php echo $newImdbID?>" onerror="this.onerror=null;this.src='404.jpg';">
<?php 
echo '<br>'.'<br>'; 

echo '<br><h3>Click <a href="interface.php">here</a> to return to your queue</h3>'; 
}
else {
	echo '<br>Execute Failed: Click <a href="interface.php">here</a>'; 
		echo ' to return to previous screen';
		exit();
}

mysqli_close($mysqli);
?> 
 </body>
</html> 