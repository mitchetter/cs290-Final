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

<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
session_start();

//ajax/js code taken from content at
//http://javascript.wonderhowto.com/how-to/use-ajax-with-jquery-create-simple-login-script-383137/

?>

<script type='text/javascript' src='jquery-1.11.2.js'></script>
<script>
	$(document).ready(function() {
		$('#errorConsole').hide(); 

		$('form[name=loginForm]').submit(function() {
			$('#errorConsole').slideUp();
			$.post('ajax.php', {username: $('[name=username]').val(),
					password: $('[name=password]').val()},
					function(data) {
						if(!data.dbStatus) {
							$('#errorConsole').html(data.dbMessage).slideDown();
						} 
						if(data.success) {
							location.href=data.redirect;
						} else {
							$('#errorConsole').html(data.message).slideDown();
						}
					}, 'json');
			return false;
		});
	});
</script>

<h1>Welcome To MovieQ</h1>
<h3>Enter Your Account Information To Access Your Queue</h3>

<div id = 'errorConsole'></div>
<form action = 'index.php' method = 'post' name='loginForm'>
	<div class='fieldset'>
	<fieldset>
		<legend>User Credentials</legend>
		Enter your username:<br />
		<input name = 'username' type = 'text'><br />
		Enter your password:<br />
		<input name = 'password' type = 'password'><br />
		<input name = 'Login' type = 'submit' value = 'Login'>
	</fieldset>
	</div>
</form>

<h3>New User? Click <a href="createAccount.php">Here</a> To Create An Account.</h3>

 </body>
</html>