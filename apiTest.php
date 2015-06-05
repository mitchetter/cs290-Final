<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//no session username exists, send back to login.php
if(!isset($_SESSION['username'])) {
	header('Location: index.php');
	exit();
}

//the form data from the user
$newName = $_GET["Title"];  

//replace any whitespaces with '+' needed for multi-word strings
$searchName = preg_replace('/\s+/', '+', $newName);

//make the call with the search string, returning json object
$jsonObj = file_get_contents("http://www.omdbapi.com/?t=$searchName");

//decode json object into an array
$myArr = (json_decode($jsonObj, true));

if($myArr['Response'] != 'False') {
	//Genre is sometime multiple categories
	//example [Genre] => Action, Horror, Thriller 
	//using explode() to take the first category listed
	$genre = explode(",", $myArr['Genre']);
	//Runtime is a string of [number of minutes] + 'min'
	//example:  [Runtime] => 93 min
	//using explode() to capture only the number of minutes
	$time = explode(" ", $myArr['Runtime']);
	$image = $myArr['Poster']; 
?>
<?php

//hold variables in the session to be consumed by addVideo.php
$_SESSION['imdbID'] = $myArr['imdbID'];
$_SESSION['Title'] = $myArr['Title'];
$_SESSION['Rated'] = $myArr['Rated'];
$_SESSION['Genre'] = $genre[0];
$_SESSION['Runtime'] = $time[0];
$_SESSION['Poster'] = $myArr['Poster'];

header("refresh:3;url=addVideo.php" );
echo "<h3>"."Calling the Open Movie Database API..."."</h3>";

}
else {
	echo $myArr['Error'];
	echo '<br>Click <a href="interface.php">here</a>'; 
		echo ' to return to previous screen';
		exit();
} 
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