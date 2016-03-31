<php?
include 'credentials.php';
include ('sql-cmds.php');

?>

<html>
	<head>
		<title>Editing Profile</title>
		<script>
			function backToProfile(){
				window.location = "user_profile.php";
			}
		</script>
	</head>
	<body>
		<p>Tinder++ Profile Edit</p><br>
		<p>UserID:<p><br>
		<form method="POST">
			Username: <input type="text" name="username_text" size="6"><br>
			Name: <input type="text" name="name_text" size="6"><br>
			Password: <input type="password" name="password_text" size="6"><br>
			Confirm Password: <input type="password" name="confirm_password_text" size="6"><br>

			Age: <input type="text" name="age_text" size='6'><br>
			Location: 
			<select name="location">
				<option value="UBC">UBC</option>
				<option value="NorthVan">North Vancouver</option>
				<option value="Downtown">Downtown Vancouver</option>
				<option value="Langley">Langley</option>
				<option value="Richmond">Richmond</option>
			</select><br>
			Gender: <br>
			<input type="radio" name="gender" value="m"> Male<br>
			<input type="radio" name="gender" value="f"> Female<br>
			Preference: <br>
			Men: <input type="checkbox" name="interestedInMen" value=1>
			Women: <input type="checkbox" name="interestedInWomen" value=1>
			<input type="submit" value="Edit" action="editUserProfile.php" name="editUserProfile">
			<input type="button" value="Go back" onclick="backToProfile();">
		</form>
	</body>
</html>

<?php
  include 'sql-cmds.php';

  if ($db_conn) {

   if (array_key_exists('editUserProfile', $_POST)) {
		// Drop old table...

		$tuple = array (
			":username_text" => $_POST['username_text'],
			":name_text" => $_POST['name_text'],
			":password_text" => $_POST['password_text'],
			":confirm_password_text" => $_POST['confirm_password_text'],
			":password_hash" => '',
			":username_text" => $_POST['username_text'],
			":gender" => $_POST['gender'],
			":age_text" => $_POST['age_text'],
			":location_text" => $_POST['location_text'],
			":interestedInMen" => $_POST['interestedInMen'],
			":interestedInWomen" => $_POST['interestedInWomen'],
			":preference" => '',
		);

		// username cannot be null
		if(!isset($tuple[':username_text'])){
			echo "Username Cannot be null";
			return;
		}
		// passwords cannot be null
		if((!isset($tuple[':password_text'])) or (!isset($tuple[':confirm_password_text']))){
			echo "Password Cannot be null";
			return;
		}
		// passrwords must match
		if($tuple[':password_text'] != $tuple[':confirm_password_text']){
			echo "Passwords don't match";
			printResult($result);
			return;
		}
		if(!isset($tuple[':name_text'])){
			echo "Name cannot be null";
			return;
		}
		// gender must be selected
		if(!isset($tuple[':gender'])){
			echo "Gender cannot be null";
			return;
		}
		// age cannot be null
		if(!isset($tuple[':age_text'])){
			echo "Age cannot be null;";
			return;
		}
		// age restriction
		if($tuple[':age_text'] < 19){
			echo "Tinder is not available for teenagers.";
			return;
		}

		if($tuple[':interestedInMen'] != NULL){
			if($tuple[':interestedInWomen'] != NULL){
				$tuple[':preference'] = 2;
			}else{
				$tuple[':preference'] = 1;
			}
		}else if($tuple[':interestedInWomen'] != NULL){
			$tuple[':preference'] = 0;
		}else{
			echo "Must pick interest";
			printResult($result);
			return;
		}

		$tuple[':password_hash'] = crypt($tuple[':password_text']);
		//password_hash($tuple[':password_text'], PASSWORD_DEFAULT);
		$alltuples = array (
			$tuple
		);
		/* UserIDSequence.nextval automatically gets the next available user ID for us from the database */
		/* Note that if the insert fails, we still increment the sequence... lol */
		// Query
		executePlainSQL("Update users 
						set username = :username_text, 
							name = :name_text, 
							location = :location_text, 
							age = :age_text, 
							gender = :gender, 
							preference = :preference, 
							passwordhash = :password_hash)");

		// Create new table...
		echo "<br> creating new user <br>";
		OCICommit($db_conn);
	}

    printTable('users');
    printTable('image');

    /* Commit to save changes... */
    OCICommit($db_conn);

    /* LOG OFF WHEN YOU'RE DONE! */
    OCILogoff($db_conn);

  } else { /* if ($db_conn) */
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
  }
?>