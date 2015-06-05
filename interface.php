<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//include 'dbConnect.php';
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

$result = mysqli_query($mysqli,"SELECT * FROM videoQueue");
$filter = mysqli_query($mysqli,"SELECT * FROM videoQueue");

?>
<html>
  <head>
  	<meta charset="utf-8">
    <!-- Bootstrap core CSS -->
    <link href="styles/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="styles/queue.css" rel="stylesheet" type="text/css">
    <link href="styles/signin.css" rel="stylesheet" type="text/css">
  </head>
  <body>
  	<form align="right" name="form1" method="post" action="logout.php">
  	<label class="logoutLblPos">
  	<input name="submit2" type="submit" id="submit2" value="Log Out">
  	</label>
	</form>
  	
<h1><?php echo "$_SESSION[username]"."'s" ?> Movie Queue</h1>

<table border="1" id="videoQueue">
	<caption><h3>Current Queue</h3></caption>
	<thead>
		<tr>
			<th>Username</th>
			<th>IMDB ID</th>
			<th>Name</th>
			<th>Category</th>
			<th>Length(mins)</th>
			<th>Rated</th>
			<th>Liked?</th>
			<th>Delete</th>
			<th>Toggle Liked</th>
			<th>Poster</th>
		</tr>
	</thead>
	<tbody>

<h4>Submit this form to add a new movie</h4>
<form action="apiTest.php" method="get">
	<div class='fieldset'>
		<fieldset>
			<legend>Enter Movie Title</legend>
			<input name="Title" type="text"><br>
			<input type="submit"><br><br>
		</fieldset>
	</div>		
</form> 

<?php
//only the admin user can delete the inventory
if($_SESSION['username'] == 'admin') {
	echo "<h4>Click this button to delete all movies in inventory</h4>";
	echo '<form action="flushDB.php" method="get">';
	echo '<input type="Submit" value="Clear Inventory">';
	echo '</form>';
}
?>
<h4>Filter by Category</h4>
<form action="interface.php" method="get">

<?php
$myArr = array();
echo '<select name="myCat">';
while($entry = mysqli_fetch_array($filter)) {
	if(!in_array($entry['category'], $myArr)) {
		if($entry['category'] != NULL) {
		array_push($myArr, $entry['category']);
		echo "<option value='".$entry['category']."'>".$entry['category']."</option>";
		}	
	}
}
if(!empty($myArr)) {
	echo '<option value="All">All Movies</option>';
}
echo '<input type = "submit" value="Filter">';
echo '<br>';
echo '</select>';
echo '</form>';

if($_GET['myCat']) {
	echo '<br>'.'Current Filter: '.$_GET["myCat"];
}
else {
	$_GET['myCat'] = 'All';
} 

$valCat = $_GET['myCat'];

//populate table with filtered db contents
if(!($valCat == 'All')) {
	while($row = mysqli_fetch_array($result)) {
		if($row['category'] == $_GET['myCat']) {
				if($row['uid'] == $_SESSION['username'] || $_SESSION['username'] == 'admin') {
					echo "<tr>";
					echo "<td>".$row['uid']."</td>";
					echo "<td>".$row['imdbID']."</td>";
					echo "<td>".$row['name']."</td>";
					echo "<td>".$row['category']."</td>";
					echo "<td>".$row['length']."</td>";
					echo "<td>".$row['rated']."</td>";
					echo "<td>".$row['liked']."</td>";
					echo "<td><form method=\"get\" action=\"delVideo.php\">";
					echo "<input type=\"hidden\" name=\"indexkey\" value=\"".$row['id']."\">";
					echo "<input type=\"submit\" value=\"Remove\">";
					echo "</form>";
					echo "<td><form method=\"get\" action=\"checkout.php\">";
					echo "<input type=\"hidden\" name=\"indexkey\" value=\"".$row['id']."\">";
					echo "<input type=\"submit\" value=\"Like/Unlike\">";
					?>
			<td><img src="http://img.omdbapi.com/?apikey=<?php echo $myKey?>&i=<?php echo $row['imdbID']?>" width="120" height="120" hspace="10" onerror="this.onerror=null;this.src='404.jpg';"></td>
			<?php
					echo "</form>";
					echo "</tr>";
					}

			}
	}
}
else {
	//unfiltered (all movies to be listed)
	while($row = mysqli_fetch_array($result)) {
		if($row['uid'] == $_SESSION['username'] || $_SESSION['username'] == 'admin') {
			echo "<tr>";
			echo "<td>".$row['uid']."</td>";
			echo "<td>".$row['imdbID']."</td>";
			echo "<td>".$row['name']."</td>";
			echo "<td>".$row['category']."</td>";
			echo "<td>".$row['length']."</td>";
			echo "<td>".$row['rated']."</td>";
			echo "<td>".$row['liked']."</td>";
			echo "<td><form method=\"get\" action=\"delVideo.php\">";
			echo "<input type=\"hidden\" name=\"indexkey\" value=\"".$row['id']."\">";
			echo "<input type=\"submit\" value=\"Remove\">";
			echo "</form>";
			echo "<td><form method=\"get\" action=\"checkout.php\">";
			echo "<input type=\"hidden\" name=\"indexkey\" value=\"".$row['id']."\">";
			echo "<input type=\"submit\" value=\"Like/Unlike\">";
			?>
			<td><img src="http://img.omdbapi.com/?apikey=<?php echo $myKey?>&i=<?php echo $row['imdbID']?>" width="120" height="120" hspace="10" onerror="this.onerror=null;this.src='404.jpg';"></td>
			<?php
			echo "</form>";
			echo "</tr>";
			}
		}
}

mysqli_close($mysqli); 
?>
 </body>
</html> 