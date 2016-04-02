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
		<h2>Your Profile</h2><br>
		<input ng-model='sampleVariable' type='text'><br>
		<?php
		echo "Name: <b><i>$user_name</b></i><br>";
		echo "Location: <b><i>$user_location</b></i><br>";
		echo "Age: <b><i> $user_age</b></i><br>";
		echo "Gender: <b><i> $user_gender</b></i><br>";
		echo "Interested In: <b><i> $user_interest</b></i><br>";
		?>
		
		Notice how this variable dynamically changes when you change the first one: <input ng-model='sampleVariable' readonly='true'>
		</p>

		<?php
		/* Print interests */
		echo "<b>Your Interests</b><ul>";
		$userInterests = query_getUserInterests($user_userid);
		foreach ($userInterests as $interest) {
			echo "<li>$interest</i>";
		}
		echo "</ul>";

		/* Print photos */
		echo "<b>Your Photos</b><ul>";
		$result = query_images($user_userid);
		foreach ($result['images'] as $img) {
      		echo "<p><img src=\"" . $img . "\" width=150></img></p>";
      	}
      	echo "</ul>";
		?>


		<input id="findMatches" type="submit" value="Find Matches" name="findMatches" onclick="findMatches()">
		<input id="editProfile" type="submit" value="Edit Profile" name="editProfile" onclick="editProfile()">
		<b id="logout"><a href="logout.php">Log Out</a></b>
	</body>
</html>


