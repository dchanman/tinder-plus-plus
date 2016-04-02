<?php
include ('business_session.php');

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();

$name = $_SESSION['login_business'];

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
		echo "<h1>Edit Business Profile ($user_name)</h1>";
		?>
		<form method="POST">
			<?php
			echo 'Name: <input type="text" name="name_text" size="6" value="'.$user_name.'"><br>';
			echo 'Age: <input type="text" name="age_text" size="6" value="'.$user_age.'"><br>';
			echo 'Location:
			<select name="location_text">
				<option value="UBC">UBC</option>
				<option value="Vancouver">Vancouver</option>
				<option value="North Vancouver">North Vancouver</option>
				<option value="Downtown">Downtown Vancouver</option>
				<option value="Langley">Langley</option>
				<option value="Richmond">Richmond</option>
				<option selected=selected>'.$user_location.'</option>
			</select><br>';
			echo 'Gender: <br>
			<input type="radio" name="gender" value="m" '.($user_gender == "m" ? 'checked="checked"' : '').'> Male<br>
			<input type="radio" name="gender" value="f" '.($user_gender == "f" ? 'checked="checked"' : '').'> Female<br>';
			echo 'Preference: <br>';
			echo 'Men: <input type="checkbox" name="interestedInMen" value="m" '.(strpos($user_preference, 'm') === FALSE ? '' : 'checked').'>';
			echo 'Women: <input type="checkbox" name="interestedInWomen" value="f" '.(strpos($user_preference, 'f') === FALSE ? '' : 'checked').'>';
			?>
			<input type="submit" value="Edit" action="editUserProfile.php" name="editUserProfile">
			<input type="button" value="Return to profile" onclick="backToProfile();">
		</form>

		<?php
		/* Print photos */
		echo "<h1>Edit Photos</h1>";
		$result = query_images($user_userid);
		for ($i = 0; $i < 3; $i++) {
      		echo "<p><img src=\"" . $result[$i] . "\" width=100></img></p>";
      		echo '<form method="POST">';
      		echo '<input type="text" name="img" size="80" value='.$result[$i].'>';
      		echo '<input type="hidden" name="imgindex" value="'.$i.'"">';
      		echo '<input type="submit" value="Edit" action="editUserProfile.php" name="editUserImage"><br>';
      		echo '</form>';
      	}
      	echo "</ul>";
      	/* Log out when finished! */
		OCILogoff($db_conn);
		include 'footer_menu.php';
		?>

	</body>
</html>
