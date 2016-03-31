<?php
include ('credentials.php');
include ('session.php');

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();

$name = $_SESSION['login_user'];

?>
<html>
	<head>
		<title>Dashboard</title>
		<script>
			function editProfile(){
				window.location = "editUserProfile.php";
			}
		</script>
	</head>
	<body>
		<b id="welcome">Welcome <i><?php echo $user_name; ?></i></b>
		<br>

		<p>
		<h2>Your Info</h2><br>
		Name: <i><?php echo $user_name; ?></i><br> 
		Location: <i><?php echo $user_location; ?></i><br>
		Age: <i><?php echo $user_age; ?></i><br>
		Gender: <i><?php echo $user_gender; ?></i><br>
		Interested In: <i><?php echo $user_interest; ?></i><br>

		</p>


		<input id="startTinder" type="submit" value="Start Tinder" name="StartTinder">
		<input id="editProfile" type="submit" value="Edit Profile" name="editProfile" onclick="editProfile()">
		<b id="logout"><a href="logout.php">Log Out</a></b>
	</body>
</html>


