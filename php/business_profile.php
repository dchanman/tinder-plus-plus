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
    	<link href="assets/css/custom.css" rel="stylesheet">
		<script src="assets/js/custom.js"></script>
		
	</head>
	<body>
		<?php include 'menu.php';?>
		<div class="maincontent">
		<h2><b id="welcome">Welcome, <i><?php echo $name; ?></i></b></h2>

		<p>
		<h3>Your Info</h3><br>
		BusinessID: <i><?php echo $business_id ?></i><br> 
		Businessname: <i><?php echo $name; ?></i><br>
		Location: <i><?php echo $business_location; ?></i><br>
		</p>
		<div class="container">
		<?php
		/* Print activities */
		echo "<h2>Your Activities</h2>";
		$activities = query_getActivitiesWithCompanyName($name);
		$i = 0;
		foreach ($activities as $activity) {
			if ($i %3 == 0){
				if ($i != 0) echo "</div>";
				echo "<div class='container jumbotron'>";
			} 

			echo "<div class='col-xs-4'>";
			echo "<h4><b>" . $activity['activity'] ."</b></h4>";
			echo $activity['scheduledTime'] ."<br>";
			echo $activity['discount'] ."% off<br>";
			echo "</div>";
			$i++;

		}
		if($i % 3 == 0) echo "</div>";
		?>
		</div>

		<input id="editProfile" type="submit" value="Edit Activities" name="editProfile" class="btn btn-default" onclick="editActivities();">
		<input id="editProfile" type="submit" value="Edit Profile" name="editProfile" class="btn btn-default" onclick="editBusinessProfile();">
		<input id="logout" type="submit" value="Logout" name="logout" class="btn btn-default" onclick="logout();">
		</div>
	</body>
</html>


