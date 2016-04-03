<?php
//include ('credentials.php');
include ('session.php');

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();

$name = $_SESSION['login_user'];
if ($db_conn) {

	if (array_key_exists('editUserProfile', $_POST)) {

		if(!isset($_POST['name_text'])){
			echo "Name cannot be null";
			return;
		}
		/* gender must be selected */
		if(!isset($_POST['gender'])){
			echo "Gender cannot be null";
			return;
		}
		/* age cannot be null */
		if(!isset($_POST['age_text'])){
			echo "Age cannot be null;";
			return;
		}
		/* age restriction */
		if($_POST['age_text'] < 19){
			echo "Tinder is not available for teenagers.";
			return;
		}

		$new_preference = '';
		if($_POST['interestedInMen'] != NULL){
			$new_preference .= 'm';
		}

		if($_POST['interestedInWomen'] != NULL){
			$new_preference .= 'f';
		}

		/* Update */
		update_userProfile($user_userid, $_POST['name_text'], $_POST['location_text'], $_POST['age_text'], $_POST['gender'], $new_preference);

		/* Commit to save changes... */
		OCICommit($db_conn);
		OCILogoff($db_conn);

		/* Redirect to a success page */

		header('Location: user_profile.php');
		exit();

	} else if (array_key_exists('editUserImage', $_POST)) {
		$imageindex = $_POST['imgindex'] + 1;
		$imageurl = $_POST['img'];
		insert_image($user_userid, $imageurl, $imageindex);

		/* Commit to save changes... */
		OCICommit($db_conn);
	} else if (array_key_exists('deleteUserImage', $_POST)){
		// should we decrement imageindex
		$imageindex = $_POST['imgindex'];
		delete_photo($user_userid, $imageindex);
		OCICommit($db_conn);
	}

	/* Commit to save changes... */
	OCICommit($db_conn);

} else { /* if ($db_conn) */
	echo "cannot connect";
	$e = OCI_Error(); /* For OCILogon errors pass no handle */
	echo htmlentities($e['message']);
}
?>

<html>
	<head>
    	<link href="assets/css/custom.css" rel="stylesheet">
		<?php include 'head-includes.php' ?>
		<title>Editing Profile</title>
		<script>
			function backToProfile() {
				window.location = "user_profile.php";
			}

			function deleteAccount() {
				window.location = "user_delete.php";
			}
		</script>
	</head>
	<body>
		<?php include 'menu.php';?>
		<div class="maincontent">
			<div class="container">
				<h1 class='jumbotron' style='text-align: center;'>Edit Profile (<?php echo $user_name?>)</h1>
				<form method="POST" class="form-inline">
					<?php
					echo 'Name: <input type="text" class="form-control" name="name_text" size="20" value="'.$user_name.'"><br>';
					echo 'Age : <input type="text" class="form-control" name="age_text" size="20" value="'.$user_age.'"><br>';
					
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

					echo 'Gender: <br>
					<input type="radio" name="gender" value="m" '.($user_gender == "m" ? 'checked="checked"' : '').'> Male<br>
					<input type="radio" name="gender" value="f" '.($user_gender == "f" ? 'checked="checked"' : '').'> Female<br>';
					echo 'Preference: <br>';
					echo '<input type="checkbox" name="interestedInMen" value="m" '.(strpos($user_preference, 'm') === FALSE ? '' : 'checked').'> Men</checkbox><br>';
					echo '<input type="checkbox" name="interestedInWomen" value="f" '.(strpos($user_preference, 'f') === FALSE ? '' : 'checked').'> Women</checkbox><br>';
					?>
					<input type="submit" class="btn btn-default" value="Edit" action="editUserProfile.php" name="editUserProfile">
					<input type="button" class="btn btn-default" value="Return to profile" onclick="backToProfile();">
				</form>

				<?php
				/* Print photos */
				echo "<h1>Edit Photos</h1>";
				$result = query_images($user_userid);
				for ($i = 0; $i < 3; $i++) {
					echo "<p><img src=\"" . $result[$i] . "\" width=100></img></p>";
					echo '<form method="POST" class="form-inline">';
					echo '<input type="text" class="form-control" name="img" size="80" value='.$result[$i].'>';
					echo '<input type="hidden" name="imgindex" value="'.$i.'"">';
					echo '<input type="submit" class="btn btn-default" value="Edit" action="editUserProfile.php" name="editUserImage"><br>';
					echo '<input type="submit" class="btn btn-default" value="Delete" action="editUserProfile.php" name="deleteUserImage"><br>';
					echo '</form>';
				}
				echo "</ul>";
				?>
				

				<h1>Delete Account</h1>
				<input type="button" class="btn btn-danger" value="Delete Account" onclick="deleteAccount();"><br><br>

				<?php
				/* Log out when finished! */
				OCILogoff($db_conn);
				?>
			</div>
		</div>

	</body>
</html>
