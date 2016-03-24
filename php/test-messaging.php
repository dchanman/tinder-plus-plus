<html>
 	<head>
  		<title>Welcome to Tinder++</title>
	</head>
 	<body>
		<p>Tinder++ Messages</p><br>
		<p>User<p><br>
		<form method="POST" action="newuser.php">
			Username: <input type="text" name="username_text" size="6"><br>
			Name: <input type="text" name="name_text" size="6"><br>
			Password: <input type="password" name="password_text" size="6"><br>
			Confirm Password: <input type="password" name="confirm_password_text" size="6"><br>

			Age: <input type="text" name="age_text" size='6'><br>
			Location: <input type="text" name="location_text" size="6"><br>
			Gender: <br>
			<input type="radio" name="gender" value="m"> Male<br>
			<input type="radio" name="gender" value="f"> Female<br>
			Preference: <br>
			Men: <input type="checkbox" name="interestedInMen" value=1>
			Women: <input type="checkbox" name="interestedInWomen" value=1>
			<input type="submit" value="Sign Up!" name="signup">
	</body>
</html>

<?php
  include 'sql-cmds.php';	
?>
