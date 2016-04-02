<?php
//include ('credentials.php');
include ('session.php');

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();

$name = $_SESSION['login_user'];
if ($db_conn) {

if (array_key_exists('editUserInterests', $_POST)) {

	$interests = query_getInterests();
	foreach ($interests as $int) {
		if (isset($_POST[$int."_checkbox"])) {
			insert_userInterest($user_userid, $int);
		} else {
			remove_userInterest($user_userid, $int);
		}
	}

		/* Commit to save changes... */
	OCICommit($db_conn);
	OCILogoff($db_conn);

	/* Redirect to a success page */

	header('Location: user_profile.php');
	exit();
}
	/* Commit to save changes... */
	OCICommit($db_conn);

} else { /* if ($db_conn) */
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}
?>

<html>
	<head>
		<?php include 'head-includes.php' ?>
		<title>Editing Profile</title>
		<script>
			function backToProfile(){
				window.location = "user_profile.php";
			}
		</script>
	</head>
	<body>
		<?php include 'menu.php';?>
		<?php 
		echo "<h1>Edit Interests ($user_name)</h1>";
		?>
		<form method="POST">
			<?php

			echo '<h4><b>Interests: </b></h4>';
			$interests = query_getInterests();
			$userInterests = query_getUserInterests($user_userid);
			foreach ($interests as $int) {
				/* The following echos all print a single line for the checkbox and label. This is hacky as hell. Sorry guys */

				/* We want a checkbox */
				echo '<input type="checkbox" ';
				/* The variable name of the checkbox depends on the interest name */
				echo 'name="'.$int.'_checkbox" ';
				/* We want to check the box automatically if the user already set this interest */
				echo (in_array($int, $userInterests) === FALSE ? '' : 'checked').'>';
				/* Print the text label for the checkbox */
				echo " $int <br>";
			}
			?>
			<input type="submit" value="Edit" action="editUserInterests.php" name="editUserInterests">
			<input type="button" value="Go back" onclick="backToProfile();">
		</form>

		<?php
		printTable('users');
		printTable('interestedIn');
		/* LOG OFF WHEN YOU'RE DONE! */
		OCILogoff($db_conn);
		?>
		<?php 
		include 'footer_menu.php';
		?>

	</body>
</html>
