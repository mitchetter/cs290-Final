<?php
session_start();
//echo 'Logout Page';

//cookie deletion code found at
//http://stackoverflow.com/questions/13862854/deleting-a-php-cookie-upon-user-logout
if(isset($_COOKIE[session_name()])):
        setcookie(session_name(), '', time()-7000000, '/');
    	endif;

if(isset($_GET['logout'])) {
	session_unset(); //free session vars
	session_destroy(); //destroy all data associated with current session
}
header("refresh:3;url=index.php" );
echo "<h3>"."Logging Out..."."</h3>";
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