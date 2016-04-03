<?php
include 'session.php';

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();

if ($db_conn) {

	if (array_key_exists('deleteAccount', $_POST)) {

		echo "Deleting user $user_userid";

		delete_user($user_userid);

		/* Commit to save changes... */
		OCICommit($db_conn);

		/* LOG OFF WHEN YOU'RE DONE! */
		OCILogoff($db_conn);

		/* Destory the session */
		session_destroy();

		/* Redirect to home page */
		header('Location: index.php');
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
    	<link href="assets/css/custom.css" rel="stylesheet">
  		<title>Edit Profile</title>
		<?php include 'head-includes.php'; ?>
	
	</head>
	<script>
		function backToProfile(){
			window.location = "user_profile.php";
		}
	</script>
 	<body>
 		<?php include 'menu.php'; ?>
		<div class="maincontent">
				<h1>Delete Account</h1>
				<?php
				echo "<p>Hey $user_name, we're sad to see you go. Are you sure you want to delete your account? This is irreversable.</p>";
				?>
				<form method="POST" action="user_delete.php">
					<input type="submit" class="btn btn-danger" value="Yes I would like to delete my account" action="user_delete.php" name="deleteAccount">
					<input type="button" class="btn btn-info" value="Return to profile" onclick="backToProfile();">
				</form>
		</div>
	</body>
</html>
