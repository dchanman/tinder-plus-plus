<?php
include 'business_session.php';

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();
?>

<html>
 	<head>
    	<link href="assets/css/custom.css" rel="stylesheet">
  		<title>Edit Profile</title>
		<?php include 'head-includes.php'; ?>
	
	</head>
	<script>
		function backToProfile() {
			window.location = "business_profile.php";
		}

		function editActivities() {
			window.location = "editBusinessActivities.php";
		}
	</script>
 	<body>
 		<?php include 'menu.php'; ?>
		<div class="maincontent">
				<h1>Delete Account</h1>
				<?php
				echo "<p>Hey $business_username, we're sad to see you go. Are you sure you want to delete your account? This is irreversable.</p>";
				?>
				<form method="POST" action="business_delete.php">
					<input type="submit" class="btn btn-danger" value="Yes I would like to delete my account" action="business_delete.php" name="deleteAccount">
					<input type="button" class="btn btn-info" value="Return to profile" onclick="backToProfile();">
				</form>
				<?php
				if ($db_conn) {

					if (array_key_exists('deleteAccount', $_POST)) {

						$result = delete_business($business_id);

						if ($result["SUCCESS"] == 0) {
							if ($result["ERRCODE"] == 2292) {
								echo "<p>Your business still has some activities available for customers. Please delete them before closing your account.</p>";
								echo '<input type="button" class="btn btn-warning" value="Manage Activities" onclick="editActivities();">';
							} else {
								echo "Uh oh, unrecognized error code: ";
								echo $result['ERRCODE'];
							}
						} else {
							/* Deleted account successfully */

							/* Commit to database */
							OCICommit($db_conn);
				    		OCILogoff($db_conn);

							/* Redirect to login page */
				    		header("Location: index.php");
						}
					}

					/* LOG OFF WHEN YOU'RE DONE! */
					OCILogoff($db_conn);

					} else { /* if ($db_conn) */
						echo "cannot connect";
						$e = OCI_Error(); // For OCILogon errors pass no handle
						echo htmlentities($e['message']);
					}
				?>
		</div>
	</body>
</html>