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
	</head>
	<body>
		<?php
		include 'head-includes.php';
		include 'menu.php';
		?>
		<div class="maincontent">
			<div class="container">
				<div class="col-xs-offset-4 col-xs-4 jumbotron">
					<h2 class="center-text"><?php echo $user_name; ?></h2>
					<h3 class="center-text"><?php echo $user_location; ?></h3><br>
					<p>Age: <?php echo $user_age; ?></p>
					<p>Gender: <?php echo $user_gender; ?></p>
					<p>Seeking: <?php echo $user_interest; ?></p>
				</div>
			</div>

			<div class="container">
				<div class="col-xs-offset-4 col-xs-4 jumbotron">
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
						echo "<p><img style='border-radius: 45px;' src=\"" . $img . "\" width=150></img></p>";
					}
					echo "</ul>";
					?>
				</div>
			</div>
		</div>
		<?php 
			include 'footer_menu.php';
		?>
		</body>
</html>


