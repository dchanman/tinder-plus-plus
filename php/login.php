
<html>
 	<head>
  		<title>Login to Continue</title>
	</head>
 	<body>
 		<p>Welcome to Tinder++ </br>
 		</br>
 			Before you can enjoy our new features, please log in to continue!</p>

 		<div id="login">
 			<p>If you are a user, please log in here.</p>
 			<form method="POST" action="login.php">
 				<p>
 					<label for="login_username">Username:</label>
 					<input type="text" name="login_username" size="16"></br>
 					<label for="login_userPassword">Password:</label>
 					<input type="password" name="login_userPassword" size="16"><br>
					<input type="submit" value="Continue" name="UserSubmit"></p>
			</form>

			<p>If you are a business, please log in here.</p>

 			<form method="POST" action="login.php">
 				<p>
 					<label for="login_businessname">Business Name:</label>
 					<input type="text" name="login_businessname" size="16"></br>
 					<label for="login_businessPassword">Password:</label>
 					<input type="password" name="login_businessPassword" size="16"><br>
					<input type="submit" value="Continue" name="BusinessSubmit"></p>
			</form>
		</div>
    </body>
</html>

<?php
	include 'sql-cmds.php';
?>

