<?php
include ('credentials.php');
include ('session.php');

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();

$name = $_SESSION['login_user'];

?>
<html id='ngWrapper' ng-app='user_profile_module' ng-controller='user_profile_controller'>
	<head>
		<title>Dashboard</title>
		<?php include 'head-includes.php' ?>
		<script>
			function editProfile() {
				window.location = "editUserProfile.php";
			}

			function findMatches() {
				window.location = "match.php";
			}
		</script>
		<script src='js/ang_user_profile.js' type='text/javascript'></script>
	</head>
	<body>
		<?php include 'menu.php';?>
		<b id="welcome">Welcome <i><?php echo $user_name; ?></i></b>
		<br>

		<p>
		<h2>Your Info</h2><br>
		<input ng-model='sampleVariable' type='text'><br>
		Name: <i><?php echo $user_name; ?></i><br> 
		Location: <i><?php echo $user_location; ?></i><br>
		Age: <i><?php echo $user_age; ?></i><br>
		Gender: <i><?php echo $user_gender; ?></i><br>
		Interested In: <i><?php echo $user_interest; ?></i><br>
		Notice how this variable dynamically changes when you change the first one: <input ng-model='sampleVariable' readonly='true'>
		</p>


		<input id="findMatches" type="submit" value="Find Matches" name="findMatches" onclick="findMatches()">
		<input id="editProfile" type="submit" value="Edit Profile" name="editProfile" onclick="editProfile()">
		<b id="logout"><a href="logout.php">Log Out</a></b>
	</body>
</html>


