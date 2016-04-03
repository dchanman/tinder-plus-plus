<?php
include 'credentials.php';
include 'business_session.php';

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();

$name = $_SESSION['login_business'];

?>
<html>
	<head>
		<?php include 'head-includes.php' ?>
		<title>Dashboard</title>
		<script>
			function editBusinessProfile(){
				window.location = 'editBusinessProfile.php';
			}

			function logout(){
				window.location = 'logout.php';
			}	
		</script>
	</head>
	<body>
		<?php include 'menu.php';?>
		<b id="welcome">Welcome, <i><?php echo $name; ?></i></b>
		<br>

		<p>
		<h2>Your Info</h2><br>
		BusinessID: <i><?php echo $business_id ?></i><br> 
		Businessname: <i><?php echo $name; ?></i><br>
		Location: <i><?php echo $business_location; ?></i><br>
		</p>

		<input id="editProfile" type="submit" value="Edit Profile" name="editProfile" class="btn btn-default" onclick="editBusinessProfile();">
		<input id="logout" type="submit" value="Logout" name="logout" class="btn btn-default" onclick="logout();">
	</body>
</html>


