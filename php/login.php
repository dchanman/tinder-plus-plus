<html>
 	<head>
  		<title>Welcome to Tinder++</title>
	</head>
 	<body>
		<p>Tinder++ Login</p><br>
		<p>UserID:<p><br>
		<form method="POST" action="newuser.php">
			Username: <input type="text" name="username_text" size="6"><br>
			Password: <input type="password" name="password_text" size="6"><br>
			<input type="submit" value="Login" name="login">
	</body>
</html>

<?php
  include 'sql-cmds.php';	
?>
