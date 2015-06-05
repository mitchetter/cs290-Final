<?php
session_start();
//some code made from content at
//https://www.youtube.com/watch?v=I7P8kz1yT-k
include 'pwd.php';

//changed the sql database table for fields uid and pwd with binary attribute
//makes them case sensitive for queries

if($_POST) {
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","etterm-db",$passwd,"etterm-db");
	if(!$mysqli || $mysqli->connect_errno) {
		$data['dbStatus'] = false;
		$data['dbMessage'] = '<h4><span style="color:crimson">Database Connection Failed.  Please Try Again Later.</span></h4>';
	} else {
		$data['dbStatus'] = true;
		$search = "SELECT id FROM userAccount WHERE uid = ?";
		$stmt = $mysqli->prepare($search);
		$stmt->bind_param('s', $_POST['username']);
		$stmt->execute();
		$stmt->bind_result($id);

		if($stmt->fetch()) {
			$data['success'] = true;
			$data['takenMessage'] = '<h4><span style="color:crimson">Username Taken.  Please Try Again.</span></h4>';
 		} else {
 			$mysqli1 = new mysqli("oniddb.cws.oregonstate.edu","etterm-db",$passwd,"etterm-db");
			if(!$mysqli1 || $mysqli1->connect_errno) {
				$data['dbStatus'] = false;
				$data['dbMessage'] = '<h4><span style="color:crimson">Database Connection Failed.  Please Try Again Later.</span></h4>'; 
			} else {
					if(strlen($_POST['username']) < 4) {
					$data['uidError'] = true;
					$data['uidMessage'] = '<h4><span style="color:crimson">Username must be at least 4 characters.  Please Try Again.</span></h4>';
				} else {
					if(strlen($_POST['password']) < 4) {
					$data['pwdError'] = true;
					$data['pwdMessage'] = '<h4><span style="color:crimson">Password must be at least 4 characters.  Please Try Again.</span></h4>';
					} else {
						$data['uidError'] = false;
						$data['pwdError'] = false;
						$entry = "INSERT INTO userAccount(uid,pwd) VALUES (?, ?)";
						$stmt1 = $mysqli->prepare($entry);
						$stmt1->bind_param('ss', $_POST['username'], $_POST['password']);
						$stmt1->execute();
 						$data['availMessage'] = '<h4><span style="color:cornflowerblue">Account has been created.  Please click on the link below and proceed to the Login Page.</h4>';
 					}
 			 	}
 			 }

			mysqli_close($mysqli1);
 		} 

		mysqli_close($mysqli);
		
		}
	echo json_encode($data);		
}

?>