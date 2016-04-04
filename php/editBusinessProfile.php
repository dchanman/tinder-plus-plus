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

} else { /* if ($db_conn) */
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}
?>

<html>
 	<head>
  		<title>Edit Profile</title>
    	<link href="assets/css/custom.css" rel="stylesheet">
		<?php include 'head-includes.php' ?>
	</head>
	<script>
		function backToProfile() {
			window.location = "business_profile.php";
		}

		function deleteAccount() {
			window.location = "business_delete.php";
		}
	</script>
 	<body>
		<?php include 'menu.php';?>
		<div class="maincontent">
			<?php echo "<h1>Edit Profile ($name)</h1>"; ?>
			
			<form method="POST" action="editBusinessProfile.php" class="form-inline">
			<?php
				/* Location dropdown box */
				echo 'Location:
				<select name="location_text" class="form-control">';
				$locations = query_getLocations();
				foreach($locations as $loc) {
					/* We want to autoselect the current location */
					if (strcmp($business_location, $loc) == 0)
						echo "<option value='$loc' selected=selected>$loc</option>";
					else
						echo "<option value='$loc'>$loc</option>";
				}
				echo '</select><br>';
				?>
				<input type="submit" class="btn btn-success" value="Edit" action="editBusinessProfile.php" name="editBusinessProfile">
				<input type="button" class="btn btn-warning" value="Return to profile" onclick="backToProfile();">
			</form>

			<form method="POST" action="editBusinessProfile.php" class="form-inline">
			</form>
			<h2>Delete Account</h2>
			<input type="submit" class="btn btn-danger" value="Delete Account" onclick="deleteAccount();">

			<?php
				/* LOG OFF WHEN YOU'RE DONE! */
				OCILogoff($db_conn);
			?>
		</div>
		</body>
	</body>
</html>
