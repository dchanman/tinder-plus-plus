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
		<script src='js/ang_user_profile.js' type='text/javascript'></script>
	</head>
	<body>
		<?php
		include 'head-includes.php';
		include 'menu.php';

		echo "<h2>$user_username's profile</h2>";
		echo "<b>$user_name, $user_age$user_gender</b><br>";
		echo "<b>$user_location</b><br>";
		echo "Seeking: <b><i> $user_interest</b></i><br>";
		?>

		<?php
		/* Print interests */
		echo "<h3><b>Your Interests</b></h3><ul>";
		$userInterests = query_getUserInterests($user_userid);
		foreach ($userInterests as $interest) {
			echo "<li>$interest</i>";
		}
		echo "</ul>";

		/* Print photos */
		echo "<h3><b>Your Photos</b></h3><ul>";
		$result = query_images($user_userid);
		foreach ($result as $img) {
      		echo "<p><img src=\"" . $img . "\" width=150></img></p>";
      	}
      	echo "</ul>";
		?>
		<?php 
		include 'footer_menu.php';
		?>


		</body>
</html>


