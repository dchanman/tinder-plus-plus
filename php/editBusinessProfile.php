<?php
include ('business_session.php');

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();

$name = $_SESSION['login_business'];

if ($db_conn) {

	if (array_key_exists('editBusinessProfile', $_POST)) {

		echo $_POST['location_text'];

		update_businessProfile($business_id, $_POST['location_text']);

		/* Commit to save changes... */
		OCICommit($db_conn);

		/* LOG OFF WHEN YOU'RE DONE! */
		OCILogoff($db_conn);

		header('Location: business_profile.php');
		exit();
	}

	/* LOG OFF WHEN YOU'RE DONE! */
	OCILogoff($db_conn);

} else { /* if ($db_conn) */
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}
?>

<html>
 	<head>
  		<title>Edit Profile</title>
		<?php include 'head-includes.php' ?>
	</head>
	<script>
		function backToProfile(){
			window.location = "business_profile.php";
		}
	</script>
 	<body>
		<?php include 'menu.php';?>
		<p>Tinder++ Signup your Business!</p><br>
		<form method="POST" action="editBusinessProfile.php">
		<?php
			echo 'Location:
			<select name="location_text">
				<option value="UBC">UBC</option>
				<option value="Vancouver">Vancouver</option>
				<option value="North Vancouver">North Vancouver</option>
				<option value="Downtown">Downtown Vancouver</option>
				<option value="Langley">Langley</option>
				<option value="Richmond">Richmond</option>
				<option selected=selected>'.$business_location.'</option>
			</select><br>';
			?>
			<input type="submit" value="Edit" action="editBusinessProfile.php" name="editBusinessProfile">
			<input type="button" value="Return to profile" onclick="backToProfile();">
		</form>
		<?php 
		include 'footer_menu.php';
		?>
		</body>
	</body>
</html>