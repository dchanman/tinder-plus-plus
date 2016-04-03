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
    	<link href="assets/css/custom.css" rel="stylesheet">
	</head>
	<body>
		<?php
		include 'head-includes.php';
		include 'menu.php';
		?>
		<div class="maincontent">
			<div class="container">
				<div class="col-xs-offset-4 col-xs-4 jumbotron">
					<h2 class="center-text"><?php if($user_name) echo $user_name; else echo "Please log in first!"?></h2>
					<h3 class="center-text"><?php if($user_location) echo $user_location; ?></h3><br>
					<p>Age: <?php if($user_age) echo $user_age; ?></p>
					<p>Gender: <?php if($user_gender) echo $user_gender; ?></p>
					<p>Seeking: <?php if($user_interest) echo $user_interest; ?></p>
				</div>
			</div>

			<div class="container">
				<div class="col-xs-offset-4 col-xs-4 jumbotron">
					<?php
						if($name){
							/* Print interests */
							echo "<h3><b>Your Interests</b></h3>";
							$userInterests = query_getUserInterests($user_userid);
							foreach ($userInterests as $interest) {
								echo "$interest<br>";
							}
							/* Print photos */
							echo "<h3><b>Your Photos</b></h3>";
							$result = query_images($user_userid);
							foreach ($result as $img) {
								echo "<p><img class='photo'  src=\"" . $img . "\" width=150></img></p>";
							}
						}
					?>
				</div>
			</div>
		</div>
		<?php 
			include 'footer_menu.php';
		?>
		</body>
</html>


