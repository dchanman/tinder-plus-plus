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
 					<label for="username">Username:</label>
 					<input type="text" name="username" size="16"></br>
 					<label for="userPwd">Password:</label>
 					<input type="password" name="userPwd" size="16"><br>
					<input type="submit" value="Continue" name="UserSubmit"></p>
			</form>

			<p>If you are a business, please log in here.</p>

 			<form method="POST" action="login.php">
 				<p>
 					<label for="businessName">Business Name:</label>
 					<input type="text" name="businessName" size="16"></br>
 					<label for="businessPwd">Password:</label>
 					<input type="password" name="businessPwd" size="16"><br>
					<input type="submit" value="Continue" name="BusinessSubmit"></p>
			</form>
		</div>

		<div id="signup">
			<h1>Sign up for Free</h1>
			<button id="userSignup">User Sign Up</button>
			<button id="businessSignup">Business Sign up</button>
		</div>
    </body>
</html>

<?php
	include 'sql-cmds.php';
?>
