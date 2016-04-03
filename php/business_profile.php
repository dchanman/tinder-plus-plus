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

		<?php
		/* Print activities */
		echo "<h2>Your Activities</h2>";
		$activities = query_getActivitiesWithCompanyName($name);
		echo "<table border=0>";
		echo "<th>Activity</th>";
		echo "<th>Scheduled Time</th>";
		echo "<th>Discount</th>";
		foreach ($activities as $activity) {
			echo "<tr>";
			echo "<td>" . $activity['activity'] . "</td>";
			echo "<td>" . $activity['scheduledTime'] . "</td>";
			echo "<td>" . $activity['discount'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";

		?>

		<input id="editProfile" type="submit" value="Edit Profile" name="editProfile" class="btn btn-default" onclick="editBusinessProfile();">
		<input id="logout" type="submit" value="Logout" name="logout" class="btn btn-default" onclick="logout();">
	</body>
</html>


