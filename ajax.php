<?php
session_start();
//some code made from content at
//https://www.youtube.com/watch?v=I7P8kz1yT-k

//changed the sql database table for fields uid and pwd with binary attribute
//makes them case sensitive for querries

include 'pwd.php';

if($_POST) {
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","etterm-db",$passwd,"etterm-db");
	if(!$mysqli || $mysqli->connect_errno) {
		$data['dbStatus'] = false;
		$data['dbMessage'] = '<h4><span style="color:crimson">Database Connection Failed.  Please Try Again Later.</span></h4>';
	} else {
		$data['dbStatus'] = true;
		$data['dbMessage'] = '<h4>DB connection successful</h4>'; 
		
		$search = "SELECT id FROM userAccount WHERE uid = ? and pwd = ?";

		$stmt = $mysqli->prepare($search);

		$stmt->bind_param('ss', $_POST['username'], $_POST['password']);

		$stmt->execute();

		$stmt->bind_result($id);

		if($stmt->fetch()) {
			$data['success'] = true;
			$data['redirect'] = 'interface.php';
			$_SESSION['username'] = $_POST['username'];
 		} else {
 			$data['success'] = false;
 			$data['message'] = '<h4><span style="color:crimson">Invalid Credentials.  Please try again.</span></h4>';
 		} 

		mysqli_close($mysqli);
		}
	echo json_encode($data);		
}

?>