<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
    <!-- Bootstrap core CSS -->
    <link href="styles/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="styles/signin.css" rel="stylesheet" type="text/css">
  </head>
<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
session_start();

//logout code taken from content at
//https://www.youtube.com/watch?v=Da_hMOn-AYg
//ajax/js code taken from content at
//http://javascript.wonderhowto.com/how-to/use-ajax-with-jquery-create-simple-login-script-383137/
?>

<script type='text/javascript' src='jquery-1.11.2.js'></script>
<script>
	$(document).ready(function() {
		$('#errorConsole').hide(); 

		$('form[name=loginForm]').submit(function() {
			$('#errorConsole').slideUp();
			$.post('accountCheck.php', {username: $('[name=username]').val(),
					password: $('[name=password]').val()},
					function(data) {
						if(!data.dbStatus) {
							$('#errorConsole').html(data.dbMessage).slideDown();
						} 
						if(data.success) {
							$('#errorConsole').html(data.takenMessage).slideDown();
						} 
						if(data.uidError) {
							$('#errorConsole').html(data.uidMessage).slideDown();
						} else {
							$('#errorConsole').html(data.availMessage).slideDown();
						}
						if(data.pwdError) {
							$('#errorConsole').html(data.pwdMessage).slideDown();
						}
					}, 'json');
			return false;
		});
	});
</script>

<h1>Welcome New User</h1>
<h3>Enter Your New Account Information</h3>

<div id = 'errorConsole'></div>
<form action = 'accountCheck.php' method = 'post' name='loginForm'>
<div class='fieldset'>
<fieldset>
<legend>Your New User Credentials</legend>
Enter your new username:<br />
<input name = 'username' type = 'text'><br />
Enter your new password:<br />
<input name = 'password' type = 'password'><br />
<input name = 'Login' type = 'submit' value = 'Add Account'>
</fieldset>
</div>
</form>

<h3>Click <a href="index.php">Here</a> To Return to the Login Page.</h3>

</body>
</html>